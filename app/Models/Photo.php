<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'url_path',
        'category_id'
    ];

     public function user()
     {
         return $this->belongsTo(User::class);
     }

     public function userBookmarks()
     {
         return $this->belongsToMany(User::class, 'user_bookmarks', 'photo_id', 'user_id');
     }

     public function category()
     {
         return $this->belongsTo(PhotoCategory::class);
     }
}
