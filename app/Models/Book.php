<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'isbn',
        'author',
        'publisher',
        'synopsis',
        'cover_image',
        'affiliate_links',
        'other_info',
        'is_published',
        'is_featured',
        'allow_comments',
    ];

    protected $casts = [
        'affiliate_links' => 'array',
        'other_info' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    /**
     * Get the category for the book.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    /**
     * Get the comments for the book.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('replies');
    }

    /**
     * Get all comments for the book (flat).
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
