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

     const CATEGORIES = [
         '1' => 'Personal',
         '2' => 'Family',
         '3' => 'Nature',
         '4' => 'Architecture',
         '5' => 'Other'
     ];

     public function users()
     {
         return $this->belongsTo(User::class);
     }

     public function userBookmarks()
     {
         return $this->belongsToMany(User::class, 'user_bookmarks', 'photo_id', 'user_id');
     }
}
