<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Sebuah Sinopsis'),
            'site_logo' => Setting::get('site_logo'),
            'site_description' => Setting::get('site_description', 'Temukan sinopsis buku favorit Anda'),
            'site_email' => Setting::get('site_email', 'contact@sebuahsinopsis.com'),
            'maintenance_mode' => Setting::isMaintenanceMode(),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the site settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:100',
            'site_description' => 'nullable|string|max:500',
            'site_email' => 'nullable|email|max:100',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        // Update text settings
        Setting::set('site_name', $request->site_name);
        Setting::set('site_description', $request->site_description);
        Setting::set('site_email', $request->site_email);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $path = $request->file('site_logo')->store('logos', 'public');
            Setting::set('site_logo', $path);
        }

        // Handle logo removal
        if ($request->has('remove_logo') && $request->remove_logo) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            Setting::set('site_logo', null);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }

    /**
     * Toggle maintenance mode
     */
    public function toggleMaintenance(Request $request)
    {
        $isEnabled = Setting::toggleMaintenanceMode();
        
        return response()->json([
            'success' => true,
            'maintenance_mode' => $isEnabled,
            'message' => $isEnabled 
                ? 'Maintenance mode enabled. Public users will see the under construction page.' 
                : 'Maintenance mode disabled. Site is now live.'
        ]);
    }

    /**
     * Get current maintenance mode status
     */
    public function getMaintenanceStatus()
    {
        return response()->json([
            'maintenance_mode' => Setting::isMaintenanceMode()
        ]);
    }
}
