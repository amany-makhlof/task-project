<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'status']; // Status: pending, approved, rejected

    /**
     * Define relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define Many-to-Many relationship with Category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Define One-to-Many relationship with Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope to get posts with at least X comments
     */
    public function scopeWithMinComments(Builder $query, int $minComments)
    {
        return $query->has('comments', '>=', $minComments);
    }
}
