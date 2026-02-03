<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting.{$key}");
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode(): bool
    {
        return self::get('maintenance_mode', 'false') === 'true';
    }

    /**
     * Toggle maintenance mode
     */
    public static function toggleMaintenanceMode(): bool
    {
        $current = self::isMaintenanceMode();
        self::set('maintenance_mode', $current ? 'false' : 'true');
        return !$current;
    }
}
