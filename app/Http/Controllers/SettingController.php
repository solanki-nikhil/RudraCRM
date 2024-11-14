<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{


    public function index()
    {
        if (Auth::check()) {
            $setting = Setting::first(); // Get the first setting
            return view('settings.form', compact('setting'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Store or update the setting with multiple video upload
    public function storeOrUpdate(Request $request)
    {
        // Validate the request
        $request->validate([
            'sample' => 'nullable|string',
            'count' => 'nullable|integer',
            'videos.*' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime,image/jpeg,image/png,image/gif', // Validate multiple video files
        ]);

        // Retrieve the existing videos from the database
        $existingSetting = Setting::find(1); // Adjust this ID or criteria as necessary
        $currentVideos = $existingSetting ? json_decode($existingSetting->videos, true) : [];

        $videos = [];

        // If there are existing videos, retain them unless the user removes them
        if ($request->has('existing_videos')) {
            $videos = $request->existing_videos; // Keep only the selected existing videos
        }

        // Handle video file uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $originalName = $video->getClientOriginalName(); // Get original file name
                $video->move(public_path('video'), $originalName); // Save the video in 'public/video'

                // Store relative path with double backslashes
                $videos[] = $originalName;
            }
        }

        // Ensure videos are stored as JSON in the database
        $videosJson = json_encode($videos);

        // Delete videos that are no longer in the updated list
        $videosToDelete = array_diff($currentVideos, $videos);
        foreach ($videosToDelete as $video) {
            $videoPath = public_path('video/' . $video);
            if (file_exists($videoPath)) {
                unlink($videoPath); // Delete the video from the 'public/video' folder
            }
        }

        // Create or update the settings
        Setting::updateOrCreate(
            ['id' => 1], // Use a fixed ID or your own unique condition
            [
                'sample' => $request->sample,
                'count' => $request->count,
                'videos' => $videosJson, // Store the video paths as a JSON string in the DB
            ]
        );

        return redirect()->back()->with('success', 'Settings saved successfully.');
    }



    public function getSampleStatus()
    {
        $sample = Setting::where('id', 1)->value('sample');
        return response()->json(['sampleEmpty' => empty($sample)]);
    }



}
