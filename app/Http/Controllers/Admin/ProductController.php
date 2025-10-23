<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeDeal;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\HomeNewArrival;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ---------------------------
    // Admin Products List
    // ---------------------------
    public function index()
    {
        $products = Product::latest()->get();
        $newArrivals = HomeNewArrival::all(); 

        return Inertia::render('AdminPanel/Products/Index', [
            'products' => $products,
            'newArrivals' => $newArrivals,
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }

    // ---------------------------
    // Show create product form
    // ---------------------------
    public function create()
    {
        return Inertia::render('AdminPanel/Products/Create');
    }

    // ---------------------------
    // Show edit product form
    // ---------------------------
    public function edit(Product $product)
    {
        return Inertia::render('AdminPanel/Products/Edit', [
            'product' => $product
        ]);
    }

    // ---------------------------
    // Shop page for frontend
    // ---------------------------
    public function shop()
    {
        $products = Product::all(); // fetch all products
        $newArrivals = HomeNewArrival::with('product')->get(); // eager load products

        return Inertia::render('Shop', [
            'products' => $products,
            'newArrivals' => $newArrivals,
        ]);
    }
    
    public function home()
    {
        $products = Product::all(); 

        return inertia('Home', [
            'products' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        return Inertia::render('ProductDetails', [
            'product' => $product
        ]);
    }

    // ---------------------------
    // Store new product with file upload
    // ---------------------------
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'image_primary' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price_range' => 'required|string',
            'thumbnails' => 'nullable|array',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'description_short' => 'nullable|string',
            'description_long' => 'nullable|string',
            'additional_info' => 'nullable|array',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'sizes' => 'nullable|array',
            'review_name' => 'nullable|string',
            'review_email' => 'nullable|email',
            'review_text' => 'nullable|string',
        ]);

        // Handle primary image upload
        if ($request->hasFile('image_primary')) {
            $imagePath = $request->file('image_primary')->store('products', 'public');
            $validated['image_primary'] = Storage::url($imagePath);
        }

        // Handle thumbnails upload
        $thumbnailPaths = [];
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $thumbnail) {
                $thumbPath = $thumbnail->store('products/thumbnails', 'public');
                $thumbnailPaths[] = Storage::url($thumbPath);
            }
            $validated['thumbnails'] = $thumbnailPaths;
        }

        // Handle reviews data
        $reviewsData = [];
        if ($request->review_name && $request->review_text) {
            $reviewsData[] = [
                'name' => $request->review_name,
                'email' => $request->review_email,
                'text' => $request->review_text,
                'date' => now()->toDateString()
            ];
        }
        $validated['reviews'] = $reviewsData;

        // Ensure arrays are properly formatted
        $validated['additional_info'] = $request->additional_info ?? [];
        $validated['categories'] = $request->categories ?? [];
      
        $validated['tags'] = $request->tags ?? [];
        $validated['sizes'] = $request->sizes ?? [];

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully!');
    }

    // ---------------------------
    // Update existing product with file upload
    // ---------------------------
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'image_primary' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price_range' => 'required|string',
            'thumbnails' => 'nullable|array',
            'thumbnails.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'description_short' => 'nullable|string',
            'description_long' => 'nullable|string',
            'additional_info' => 'nullable|array',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
            'sizes' => 'nullable|array',
            'review_name' => 'nullable|string',
            'review_email' => 'nullable|email',
            'review_text' => 'nullable|string',
        ]);

        // Handle primary image upload if new file is provided
        if ($request->hasFile('image_primary')) {
            // Delete old image if exists
            if ($product->image_primary && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image_primary))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image_primary));
            }
            
            $imagePath = $request->file('image_primary')->store('products', 'public');
            $validated['image_primary'] = Storage::url($imagePath);
        } else {
            $validated['image_primary'] = $product->image_primary;
        }

        // Handle thumbnails upload if new files are provided
        if ($request->hasFile('thumbnails')) {
            // Delete old thumbnails if exist
            if ($product->thumbnails) {
                foreach ($product->thumbnails as $oldThumb) {
                    if ($oldThumb && Storage::disk('public')->exists(str_replace('/storage/', '', $oldThumb))) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $oldThumb));
                    }
                }
            }

            $thumbnailPaths = [];
            foreach ($request->file('thumbnails') as $thumbnail) {
                $thumbPath = $thumbnail->store('products/thumbnails', 'public');
                $thumbnailPaths[] = Storage::url($thumbPath);
            }
            $validated['thumbnails'] = $thumbnailPaths;
        } else {
            // Keep existing thumbnails if no new files uploaded
            $validated['thumbnails'] = $product->thumbnails;
        }

        // Handle reviews data
        $reviewsData = [];
        if ($request->review_name && $request->review_text) {
            $reviewsData[] = [
                'name' => $request->review_name,
                'email' => $request->review_email,
                'text' => $request->review_text,
                'date' => now()->toDateString()
            ];
        }
        $validated['reviews'] = $reviewsData;

        // Ensure arrays are properly formatted
        $validated['additional_info'] = $request->additional_info ?? $product->additional_info;
        $validated['categories'] = $request->categories ?? $product->categories;
        $validated['tags'] = $request->tags ?? $product->tags;
        $validated['sizes'] = $request->sizes ?? $product->sizes;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }
    // ---------------------------
    // Admin Home Settings: Edit New Arrivals
    // ---------------------------
    public function editNewArrivals()
    {
        $products = Product::all();
        $newArrivals = HomeNewArrival::all();

        return Inertia::render('AdminPanel/HomeSetting', [
            'products' => $products,
            'newArrivals' => $newArrivals
        ]);
    }

    // ---------------------------
    // Delete product
    // ---------------------------
    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->image_primary && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image_primary))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image_primary));
        }

        if ($product->thumbnails) {
            foreach ($product->thumbnails as $thumbnail) {
                if ($thumbnail && Storage::disk('public')->exists(str_replace('/storage/', '', $thumbnail))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $thumbnail));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    // ---------------------------
    // Admin Home Settings: Update New Arrivals
    // ---------------------------
    public function updateNewArrivals(Request $request)
    {
        $request->validate([
            'new_arrivals' => 'required|array',
            'new_arrivals.*.product_id' => 'required|exists:products,id',
            'deal.*.product_id' => 'required|exists:products,id',
        ]);

        // Clear old new arrivals
        HomeNewArrival::truncate();

        // Insert new ones
        foreach ($request->new_arrivals as $item) {
            HomeNewArrival::create([
                'product_id' => $item['product_id'],
            ]);
        }
        
        // Clear old deals and insert new ones
        HomeDeal::truncate();
        foreach ($request->deal as $item) {
            HomeDeal::create([
                'product_id' => $item['product_id'],
            ]);
        }

        return back()->with('success', 'New Arrivals updated successfully!');
    }
}