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

    /////////////////// Accessors ///////////////////
    public function getCreatedAtAttribute() {
      return date('d/m/Y - h:m', strtotime($this->attributes['created_at']));
    }
    public function setSlugAttribute ($title) {
      $this->attributes['slug'] = $this->uniqueSlug($title);
    }
}
