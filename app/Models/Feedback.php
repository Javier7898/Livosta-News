<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'username', 
        'status', 
        'title',
        'image',
        'content',
        'category_id',
        'is_highlighted',
    ];

    /**
     * Get the user that owns the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the feedback belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
