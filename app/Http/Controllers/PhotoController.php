<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoCategory;
use App\Models\User;
use Illuminate\Http\Request;
use File;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $photos = Photo::with('userBookmarks', 'category')->all();

        if ($request->has('photo_category_id')) {
            $photos->where('photo_category_id', $request->photo_category_id);
        }
        $photos->orderBy('created_at', 'desc')
            ->get();

        return view('photos.index', compact('photos'));
    }

    public function downloadPhoto($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $categoryName = PhotoCategory::findOrFail($photo->photo_category_id)->name;
        $filePath = 'app/'.$categoryName.'/'.$photo->name;

        if (! File::exists(storage_path($filePath))) {
            return abort('404', 'Photo not found!');
        }

        return response()->download($filePath);
    }

    public function bookmarkPhoto($photoId)
    {
        $user = User::findOrFail(auth()->id());
        $user->bookmarkedPhotos()->attach($photoId);

        return response()->json('Photo was bookmarked!');
    }
}
