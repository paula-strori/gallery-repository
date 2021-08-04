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
        $photoCategories = PhotoCategory::all();
        $photos = Photo::with('user', 'category');
        if ($request->has('category')) {
            $photos->where('photo_category_id', $request->category);
            $filterCategory = $request->category;
        } else {
            $filterCategory = false;
        }
        if ($request->has('bookmarked')) {
            $photos->whereHas('userBookmarks', function ($q) {
                $q->where('user_id', auth()->id());
            });
            $filterBookmarked = "all";
        } else {
            $filterBookmarked = "onlyBookmarked";
        }
        $photos = $photos->orderBy('created_at', 'desc')
            ->paginate(15);

        $bookmarks = Photo::whereHas('userBookmarks', function ($q) {
            $q->where('user_id', auth()->id());
        })->pluck('id')->toArray();

        if ($bookmarks) {
            foreach ($photos as $photo) {
                if (in_array($photo->id, $bookmarks)) {
                    $photo['bookmarked'] = true;
                } else {
                    $photo['bookmarked'] = false;
                }
            }
        }

        return view('photos.index', compact('photos', 'photoCategories', 'filterCategory', 'filterBookmarked'));
    }

    public function downloadPhoto($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $categoryName = PhotoCategory::findOrFail($photo->photo_category_id)->name;
        $filePath = public_path('images/' . $categoryName . '/' . $photo->name);

        if (!File::exists($filePath)) {
            return abort('404', 'Photo not found!');
        }

        return response()->download($filePath);
    }

    public function bookmarkPhoto($photoId)
    {
        $user = User::findOrFail(auth()->id());
        $isBookmarked = $user->bookmarkedPhotos()->where('photo_id', $photoId)->exists();
        if ($isBookmarked) {
            $user->bookmarkedPhotos()->detach($photoId);
            return response()->json('Removed');
        } else {
            $user->bookmarkedPhotos()->attach($photoId);
            return response()->json('Bookmarked');
        }
    }
}
