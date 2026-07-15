<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|url',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|digits:10',
            'email' => 'nullable|email|max:255',
            'currency' => 'nullable|string|max:10',
        ]);

        $setting = Setting::first();
        if ($setting) {
            $setting->update($validated);
        } else {
            Setting::create($validated);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }
}
