<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('category_id');
            $table->boolean('is_published')->default(true)->after('other_info');
            $table->boolean('is_featured')->default(false)->after('is_published');
            $table->boolean('allow_comments')->default(true)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'is_published', 'is_featured', 'allow_comments']);
        });
    }
};
