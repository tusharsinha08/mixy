<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ShopController extends Controller
{

    public function index(Request $request)
    {
        Log::info('=== SHOP CONTROLLER CALLED ===');
        Log::info('Request Data:', [
            'category' => $request->category,
            'search' => $request->search,
            'full_url' => $request->fullUrl(),
            'all_params' => $request->all()
        ]);

        // Query products with filters
        $productsQuery = Product::query();

        // Apply category filter
        if ($request->category) {
            $requestedCategory = trim($request->category);
            Log::info('Applying category filter:', ['category' => $requestedCategory]);

            $productsQuery->where(function ($query) use ($requestedCategory) {
                // Since categories is cast to array, we can use JSON_CONTAINS or LIKE queries
                $query->whereRaw('JSON_CONTAINS(LOWER(categories), LOWER(?))', ['"' . $requestedCategory . '"'])
                    ->orWhere('categories', 'like', '%"' . $requestedCategory . '"%')
                    ->orWhere('categories', 'like', '%' . $requestedCategory . '%');
            });

            // Debug: Log products that match this category
            $matchingProducts = Product::where(function ($q) use ($requestedCategory) {
                $q->whereRaw('JSON_CONTAINS(categories, ?)', ['"' . $requestedCategory . '"'])
                    ->orWhere('categories', 'like', '%"' . $requestedCategory . '"%');
            })->get();

            Log::info('Direct query found products:', ['count' => $matchingProducts->count()]);
            foreach ($matchingProducts as $product) {
                $categories = is_array($product->categories) ? $product->categories : [];
                Log::info('Matching product:', [
                    'name' => $product->name,
                    'categories' => $product->categories, // Already an array due to cast
                    'raw_categories' => $product->getRawOriginal('categories') // Get raw JSON value
                ]);
            }
        }

        // Apply search filter
        if ($request->search) {
            $searchTerm = $request->search;
            $productsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description_short', 'like', "%{$searchTerm}%")
                    ->orWhere('description_long', 'like', "%{$searchTerm}%")
                    ->orWhere('tags', 'like', '%"' . $searchTerm . '"%');
            });
        }

        // Get filtered products
        $products = $productsQuery->get()->map(function ($product) {
            return $this->formatProductData($product);
        });

        // Get all unique categories from products
        $allCategories = $this->getAllCategories();

        Log::info('Final results:', [
            'total_products' => $products->count(),
            'applied_category' => $request->category,
            'available_categories' => $allCategories
        ]);

        return Inertia::render('Shop', [
            'products' => $products,
            'category' => $request->category,
            'search' => $request->search,
            'allCategories' => $allCategories,
            'filters' => [
                'category' => $request->category,
                'search' => $request->search,
            ]
        ]);
    }

    /**
     * Format product data for frontend
     */
    private function formatProductData(Product $product)
    {
        // Handle primary image
        $primaryImage = $product->image_primary;
        if (!$primaryImage && !empty($product->thumbnails)) {
            $primaryImage = $product->thumbnails[0];
        }
        if (!$primaryImage) {
            $primaryImage = '/assets/images/products/placeholder.jpg';
        }

        // Handle tags - already decoded by cast, but ensure it's an array
        $tags = is_array($product->tags) ? $product->tags : [];

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,

            // Images
            'image' => $primaryImage,
            'image_primary' => $primaryImage,
            'thumbnails' => is_array($product->thumbnails) ? $product->thumbnails : [],

            // Pricing
            'price' => $this->extractPrice($product->price_range),
            'price_range' => $product->price_range,
            'original_price' => $this->extractOriginalPrice($product->price_range),

            // Description
            'description' => $product->description_long ?: $product->description_short,
            'description_short' => $product->description_short,
            'description_long' => $product->description_long,

            // Ratings
            'rating' => $product->rating ?? 4,
            'review_count' => $this->extractReviewCount($product->reviews),

            // Categories and Tags - already decoded by Laravel casts
            'categories' => is_array($product->categories) ? array_filter(array_map('trim', $product->categories)) : [],
            'tags' => $tags,

            // Additional info - already decoded by casts
            'additional_info' => is_array($product->additional_info) ? $product->additional_info : [],
            'reviews' => is_array($product->reviews) ? $product->reviews : [],
            'sizes' => is_array($product->sizes) ? $product->sizes : [],

            // Flags
            'in_stock' => $product->in_stock ?? true,
            'is_featured' => $product->is_featured ?? false,
            'is_best_seller' => $product->is_best_seller ?? false,
        ];
    }

    /**
     * Decode categories from JSON string to array with better error handling
     */
    private function decodeCategories($categoriesJson)
    {
        if (!$categoriesJson) {
            return [];
        }

        Log::debug('Decoding categories:', ['raw' => $categoriesJson]);

        // Try to decode as JSON first
        $decoded = json_decode($categoriesJson, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_filter(array_map('trim', $decoded));
        }

        // If decoding fails, try various extraction methods
        $categories = [];

        if (is_string($categoriesJson)) {

            $cleaned = trim($categoriesJson, " []\"'\n\r\t\v\0");


            preg_match_all('/"([^"]+)"/', $cleaned, $matches);
            if (!empty($matches[1])) {
                $categories = array_map('trim', $matches[1]);
            } else {

                $categories = array_filter(array_map('trim', explode(',', $cleaned)));
            }
        }
        return array_filter($categories);
    }


    private function normalizeCategoryName($categoryName)
    {
        return trim($categoryName);
    }

    private function extractPrice($priceRange)
    {
        if (!$priceRange)
            return 0;

        // Handle different price formats
        if (is_numeric($priceRange)) {
            return floatval($priceRange);
        }

        // Extract first price found
        preg_match_all('/\$?(\d+\.?\d*)/', $priceRange, $matches);
        return isset($matches[1][0]) ? floatval($matches[1][0]) : 0;
    }

    private function extractOriginalPrice($priceRange)
    {
        if (!$priceRange)
            return null;

        // If price range has two prices (original - sale)
        preg_match_all('/\$?(\d+\.?\d*)/', $priceRange, $matches);
        if (isset($matches[1][1])) {
            return floatval($matches[1][1]);
        }

        return null;
    }

    private function extractReviewCount($reviews)
    {
        if (!$reviews)
            return 0;

        // Reviews are already decoded to array by Laravel cast
        if (is_array($reviews)) {
            return count($reviews);
        }

        return 0;
    }

    /**
     * Get all unique categories from all products
     */
    private function getAllCategories()
    {
        $products = Product::all();
        $allCategories = [];

        foreach ($products as $product) {
            // Categories are already arrays due to cast - no need to decode
            if (is_array($product->categories)) {
                $productCategories = array_filter(array_map('trim', $product->categories));
                $allCategories = array_merge($allCategories, $productCategories);
            }

            // Debug individual product categories
            if (!empty($productCategories)) {
                Log::debug('Product categories:', [
                    'product' => $product->name,
                    'categories' => $product->categories
                ]);
            }
        }

        $uniqueCategories = array_values(array_unique(array_filter($allCategories)));
        sort($uniqueCategories);

        Log::info('All unique categories found:', $uniqueCategories);

        return $uniqueCategories;
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Get related products (products from same categories)
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                // Categories are already arrays, but we need to query the JSON column
                if (is_array($product->categories)) {
                    foreach ($product->categories as $category) {
                        $trimmedCategory = trim($category);
                        if (!empty($trimmedCategory)) {
                            $query->orWhereRaw('JSON_CONTAINS(categories, ?)', ['"' . $trimmedCategory . '"'])
                                ->orWhere('categories', 'like', '%"' . $trimmedCategory . '"%');
                        }
                    }
                }
            })
            ->limit(8)
            ->get()
            ->map(function ($relatedProduct) {
                return $this->formatProductData($relatedProduct);
            });

        return Inertia::render('ProductDetails', [
            'product' => $this->formatProductData($product),
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function debugCategories(Request $request)
    {
        $allProducts = Product::all();
        $categoryMap = [];

        foreach ($allProducts as $product) {
            // Categories are already arrays due to cast
            if (is_array($product->categories)) {
                foreach ($product->categories as $category) {
                    $trimmedCategory = trim($category);
                    if (!empty($trimmedCategory)) {
                        if (!isset($categoryMap[$trimmedCategory])) {
                            $categoryMap[$trimmedCategory] = [];
                        }
                        $categoryMap[$trimmedCategory][] = $product->name;
                    }
                }
            }
        }

        ksort($categoryMap);

        return response()->json([
            'category_products_map' => $categoryMap,
            'total_products' => $allProducts->count(),
            'total_categories' => count($categoryMap)
        ]);
    }
}