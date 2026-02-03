<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
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
