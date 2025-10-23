<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class HeaderSettingsController extends Controller
{
  public function edit()
    {
        $headerSettings = HeaderSetting::first();
        
        return Inertia::render('AdminPanel/HeaderSettings', [
            'headerSettings' => $headerSettings
        ]);
    }


public function update(Request $request)
{
    $validated = $request->validate([
        'topbar_text' => 'nullable|string',
        'topbar_help_text' => 'nullable|string',
        'topbar_phone' => 'nullable|string',
        'logo' => 'nullable|string',
        'logo_url' => 'nullable|string',
        'search_placeholder' => 'nullable|string',
        'icon_user' => 'nullable|string',
        'icon_wishlist' => 'nullable|string',
        'icon_cart' => 'nullable|string',
        'nav_links' => 'nullable|array',
    ]);

    $headerSetting = HeaderSetting::firstOrNew([]);

    // Handle logo upload if base64
    if (isset($validated['logo']) && preg_match('/^data:image\/(\w+);base64,/', $validated['logo'], $matches)) {
        $imageData = substr($validated['logo'], strpos($validated['logo'], ',') + 1);
        $imageType = $matches[1];
        $imageData = base64_decode($imageData);

        $fileName = 'logo-' . time() . '.' . $imageType;
        $path = 'uploads/header/' . $fileName;
        Storage::disk('public')->put($path, $imageData);
        $validated['logo'] = Storage::url($path);
    }

    $headerSetting->fill($validated);
    $headerSetting->save();

    // Return updated settings to Inertia
    return redirect()->back()->with('success', 'Header settings updated successfully!');
}
}