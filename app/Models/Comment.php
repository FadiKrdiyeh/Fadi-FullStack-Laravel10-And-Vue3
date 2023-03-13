<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    /////////////////// Fillable Columns ///////////////////
    public $fillable = ['content'];

    /////////////////// Relationships ///////////////////
    // Relation Many To One With Comments
    public function user () {
      return $this->belongsTo(User::class);
    }

    // Relation Many To One With Blog
    public function blog () {
      return $this->belongsTo(Blog::class);
    }
}
