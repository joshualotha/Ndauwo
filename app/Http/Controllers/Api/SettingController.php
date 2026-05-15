<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all settings as a key-value pair for easy frontend consumption
        $settings = Setting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    /**
     * Update/Create settings.
     * Expects an array of key-value pairs.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        try {
            foreach ($data as $key => $value) {
                // Find existing setting to preserve group/type or use defaults
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_null($value) ? '' : $value]
                );
            }
            return response()->json(['message' => 'Settings updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update settings: ' . $e->getMessage()], 500);
        }
    }
    
    // Helper to upload setting image (e.g. logo)
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'key' => 'required|string'
        ]);
        
        $path = $request->file('image')->store('settings', 'public');
        
        Setting::updateOrCreate(
            ['key' => $request->key],
            [
                'value' => $path,
                'type' => 'image',
                'group' => 'appearance' // default or flexible
            ]
        );
        
        return response()->json(['url' => asset('storage/' . $path), 'path' => $path]);
    }
}
