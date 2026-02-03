<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add default site settings
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'site_name',
                'value' => 'Sebuah Sinopsis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Temukan sinopsis buku favorit Anda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_email',
                'value' => 'contact@sebuahsinopsis.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'site_name',
            'site_logo',
            'site_description',
            'site_email',
        ])->delete();
    }
};
