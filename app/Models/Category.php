<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class Category extends Model
{
    use HasFactory;

    /////////////////// Fillable Columns ///////////////////
    public $fillable = ['name'];

    /////////////////// Relationships ///////////////////
    // Relation Many To Many With Blogs
    public function blogs () {
      return $this->belongsToMany(Blog::class, 'blog_categories');
    }
}
