<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Inertia\Inertia;

class ContactUsController extends Controller
{
    public function edit()
    {
        $contact = ContactUs::first();

        return Inertia::render('AdminPanel/ContactUsForm', [
            'contact' => $contact,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'page_title' => 'nullable|string',
            'breadcrumb_title' => 'nullable|string',
            'office_location' => 'nullable|string',
            'phone_numbers' => 'nullable|string',
            'emails' => 'nullable|string',
            'newsletter_title' => 'nullable|string',
            'newsletter_subtitle' => 'nullable|string',
            'call_us_text' => 'nullable|string',
            'call_us_number' => 'nullable|string',
        ]);

        $contact = ContactUs::first() ?? new ContactUs();

        $contact->fill([
            'page_title' => $validated['page_title'] ?? '',
            'breadcrumb_title' => $validated['breadcrumb_title'] ?? '',
            'office_location' => $validated['office_location'] ?? '',
            'phone_numbers' => !empty($validated['phone_numbers'])
                ? array_map('trim', explode(',', $validated['phone_numbers']))
                : [],
            'emails' => !empty($validated['emails'])
                ? array_map('trim', explode(',', $validated['emails']))
                : [],
            'newsletter_title' => $validated['newsletter_title'] ?? '',
            'newsletter_subtitle' => $validated['newsletter_subtitle'] ?? '',
            'call_us_text' => $validated['call_us_text'] ?? '',
            'call_us_number' => $validated['call_us_number'] ?? '',
        ]);

        $contact->save();

        return back()->with('success', 'Contact page updated successfully.');
    }
}
