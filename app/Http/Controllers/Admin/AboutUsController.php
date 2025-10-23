<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AboutUsController extends Controller
{
    public function edit()
    {
        $aboutUs = AboutUs::first();
        $teamMembers = TeamMember::all();

        $formatted = [
            'hero' => [
                'title' => $aboutUs->hero_title ?? '',
                'subtitle' => $aboutUs->hero_subtitle ?? '',
                'buttonText' => $aboutUs->hero_button_text ?? '',
            ],
            'whoWeAre' => [
                'text' => $aboutUs->who_we_are ?? '',
            ],
            'ourValues' => [
                'text' => $aboutUs->our_values ?? '',
            ],
            'ourMission' => [
                'text' => $aboutUs->our_mission ?? '',
            ],
            'funFacts' => $aboutUs->fun_facts ?? [],
            'teamMembers' => $teamMembers->map(function($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'role' => $member->role,
                    'image' => $member->image ? asset($member->image) : '',
                ];
            })->toArray(),
        ];

        return Inertia::render('AdminPanel/AboutUsForm', [
            'aboutUs' => $formatted,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero' => 'array',
            'whoWeAre' => 'array',
            'ourValues' => 'array',
            'ourMission' => 'array',
            'funFacts' => 'array',
        ]);

        $aboutUs = AboutUs::firstOrNew();

        // Handle team members image uploads
        $teamMembers = $data['teamMembers'] ?? [];
        
        foreach ($teamMembers as $index => &$member) {
            $imagePath = $member['image'] ?? '';

            // Check for file upload
            if ($request->hasFile("teamMembers.{$index}.image_file")) {
                // Delete old image if exists
                if (!empty($member['image']) && strpos($member['image'], 'storage/') !== false) {
                    $oldImagePath = str_replace('/storage/', '', $member['image']);
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Store new image
                $path = $request->file("teamMembers.{$index}.image_file")->store('uploads/team-members', 'public');
                $imagePath = Storage::url($path);
            }

            $member['image'] = $imagePath;
        }

        $aboutUs->fill([
            'hero_title' => $data['hero']['title'] ?? null,
            'hero_subtitle' => $data['hero']['subtitle'] ?? null,
            'hero_button_text' => $data['hero']['buttonText'] ?? null,
            'who_we_are' => $data['whoWeAre']['text'] ?? null,
            'our_values' => $data['ourValues']['text'] ?? null,
            'our_mission' => $data['ourMission']['text'] ?? null,
            'fun_facts' => $data['funFacts'] ?? [],
        ]);

        $aboutUs->save();

        return back()->with('success', 'About Us updated successfully.');
    }

    public function updateFunFacts(Request $request)
    {
        $request->validate([
            'funFacts' => 'array',
        ]);

        $aboutUs = AboutUs::firstOrNew();
        $aboutUs->fun_facts = $request->funFacts;
        $aboutUs->save();

        return back()->with('success', 'Fun Facts updated successfully.');
    }

    public function updateTeamMembers(Request $request)
{
    $request->validate([
        'teamMembers' => 'array',
    ]);

    $existingIds = TeamMember::pluck('id')->toArray();
    $updatedIds = [];

    foreach ($request->input('teamMembers', []) as $memberData) {
        $imagePath = $memberData['image'] ?? '';

        // Handle base64 image data for new uploads
        if (isset($memberData['image']) && preg_match('/^data:image\/(\w+);base64,/', $memberData['image'], $matches)) {
            $imageData = substr($memberData['image'], strpos($memberData['image'], ',') + 1);
            $imageType = $matches[1];
            $imageData = base64_decode($imageData);

            $fileName = 'team-member-' . time() . '-' . uniqid() . '.' . $imageType;
            $path = 'uploads/team-members/' . $fileName;
            Storage::disk('public')->put($path, $imageData);
            $imagePath = 'storage/' . $path; // Add storage/ prefix
        } elseif (isset($memberData['image']) && filter_var($memberData['image'], FILTER_VALIDATE_URL)) {
            // If it's already a URL, extract just the path part
            $parsedUrl = parse_url($memberData['image']);
            $imagePath = ltrim($parsedUrl['path'], '/');
            
            // Ensure it has storage/ prefix if it's a local path
            if (strpos($imagePath, 'storage/') === false && strpos($imagePath, 'uploads/') !== false) {
                $imagePath = 'storage/' . $imagePath;
            }
        }

        if (isset($memberData['id'])) {
            $teamMember = TeamMember::find($memberData['id']);
            if ($teamMember) {
                $teamMember->update([
                    'name' => $memberData['name'] ?? '',
                    'role' => $memberData['role'] ?? '',
                    'image' => $imagePath ?: $teamMember->image,
                ]);
                $updatedIds[] = $memberData['id'];
            }
        } else {
            $teamMember = TeamMember::create([
                'name' => $memberData['name'] ?? '',
                'role' => $memberData['role'] ?? '',
                'image' => $imagePath,
            ]);
            $updatedIds[] = $teamMember->id;
        }
    }

    $idsToDelete = array_diff($existingIds, $updatedIds);
    if (!empty($idsToDelete)) {
        TeamMember::whereIn('id', $idsToDelete)->delete();
    }

    return back()->with('success', 'Team Members updated successfully.');
}

    public function show()
    {
        $aboutUs = AboutUs::first();
        $teamMembers = TeamMember::all();

        if (!$aboutUs) {
            return Inertia::render('AboutUs', [
                'aboutUs' => null
            ]);
        }

        return Inertia::render('AboutUs', [
            'aboutUs' => [
                'hero' => [
                    'title' => $aboutUs->hero_title,
                    'subtitle' => $aboutUs->hero_subtitle,
                    'buttonText' => $aboutUs->hero_button_text,
                ],
                'whoWeAre' => ['text' => $aboutUs->who_we_are],
                'ourValues' => ['text' => $aboutUs->our_values],
                'ourMission' => ['text' => $aboutUs->our_mission],
                'funFacts' => $aboutUs->fun_facts ?? [],
                'teamMembers' => $teamMembers->map(function($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'role' => $member->role,
                        'image' => $member->image ? asset($member->image) : '',
                    ];
                })->toArray(),
            ],
        ]);
    }

    /**
     * Remove a team member image
     */
    public function removeTeamMemberImage(Request $request, $memberIndex)
    {
        $aboutUs = AboutUs::first();
        if (!$aboutUs || !isset($aboutUs->team_members[$memberIndex])) {
            return response()->json(['error' => 'Team member not found'], 404);
        }

        $teamMembers = $aboutUs->team_members;
        $imagePath = $teamMembers[$memberIndex]['image'] ?? '';

        // Delete physical file
        if (!empty($imagePath) && strpos($imagePath, 'storage/') !== false) {
            $filePath = str_replace('/storage/', '', $imagePath);
            Storage::disk('public')->delete($filePath);
        }

        // Remove image from team member
        $teamMembers[$memberIndex]['image'] = '';

        $aboutUs->team_members = $teamMembers;
        $aboutUs->save();

        return response()->json(['success' => 'Image removed successfully']);
    }
}