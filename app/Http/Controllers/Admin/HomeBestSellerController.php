<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBestSeller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeBestSellerController extends Controller
{
    public function index()
    {
        $bestSellers = HomeBestSeller::all();
        return Inertia::render('AdminPanel/BestSellers/Index', [
            'bestSellers' => $bestSellers,
        ]);
    }

    public function create()
    {
        return Inertia::render('AdminPanel/BestSellers/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'home_setting_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'price_range' => 'nullable|string|max:100',
            'image' => 'nullable|image',
            'rating' => 'nullable|integer|min:1|max:5',
            'button_text' => 'nullable|string|max:50',
            'button_icon' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/bestsellers', 'public');
            $data['image'] = '/storage/' . $path;
        }

        HomeBestSeller::create($data);

        return redirect()->route('admin.home-best-sellers.index')->with('success', '✅ Best Seller added successfully!');
    }

    public function edit(HomeBestSeller $homeBestSeller)
    {
        return Inertia::render('AdminPanel/BestSellers/Edit', [
            'item' => $homeBestSeller,
        ]);
    }

    public function update(Request $request, HomeBestSeller $homeBestSeller)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price_range' => 'nullable|string|max:100',
            'image' => 'nullable|image',
            'rating' => 'nullable|integer|min:1|max:5',
            'button_text' => 'nullable|string|max:50',
            'button_icon' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/bestsellers', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $homeBestSeller->update($data);

        return redirect()->route('admin.home-best-sellers.index')->with('success', '✅ Best Seller updated successfully!');
    }

    public function destroy(HomeBestSeller $homeBestSeller)
    {
        $homeBestSeller->delete();
        return redirect()->back()->with('success', '🗑️ Best Seller deleted successfully!');
    }
}
