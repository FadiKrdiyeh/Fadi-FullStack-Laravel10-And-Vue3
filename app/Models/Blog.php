<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Blog extends Model
{
    use HasFactory;

    /////////////////// Fillable Columns ///////////////////
    // public $fillable = ['title', 'html_content', 'json_content', 'slug', 'is_accepted'];
    public $fillable = ['title', 'content', 'slug', 'is_accepted'];

    /////////////////// Mutators ///////////////////
    // Store Unique Slug From Title
    public function setSlugAttribute ($title) {
      $this->attributes['slug'] = $this->uniqueSlug($title);
    }

    /////////////////// Relationships ///////////////////
    // Relation Many To One With User
    public function user () {
      return $this->belongsTo(User::class);
    }

    // Relation One To Many With Comments
    public function comments () {
      return $this->hasMany(Comment::class);
    }

    // Relation Many To Many With Categories
    public function categories () {
      return $this->belongsToMany(Category::class, 'blog_categories');
    }

    /////////////////// Private Functions ///////////////////
    // Generate A Unique Slug
    private function uniqueSlug($title)
    {
        $slug = Str::slug($title, '-');
        $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';

        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }
}
