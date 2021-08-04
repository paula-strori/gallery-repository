<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($userId)
    {
        $userProfile = User::findOrFail($userId);
        $userPhotos = Photo::with('category')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $photoCategories = PhotoCategory::all();

        $bookmarks = Photo::whereHas('userBookmarks', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->pluck('id')->toArray();

        if ($bookmarks) {
            foreach ($userPhotos as $photo) {
                if (in_array($photo->id, $bookmarks)) {
                    $photo['bookmarked'] = true;
                } else {
                    $photo['bookmarked'] = false;
                }
            }
        }

        return view('users.show', compact('userProfile', 'userPhotos', 'photoCategories'));
    }

    public function update(Request $request, $userId)
    {
        if (auth()->id() != $userId) {
            return abort('401', 'You do not have access to edit these data!');
        }
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
        ],
            [
                'name.required' => 'Name is required!',
                'surname.required' => 'Surname is required!',
                'email.required' => 'e-Mail address is required!',
                'email.email' => 'The e-Mail address you provided is invalid!',
                'email.unique' => 'This e-Mail address is already taken!',
            ]
        );

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $userProfile = User::findOrFail($userId);

        $userProfile->update($request->all());

        return back()->with(['message' => 'User Profile was updated successfully!']);
    }

    public function addPhoto(Request $request, $userId)
    {
        if ($request->hasFile('img')) {
            $categoryName = PhotoCategory::findOrFail($request->photo_category_id)->name;
            $path = public_path('images/' . $categoryName);
            $image = $request->img;
            $extension = $image->getClientOriginalExtension();
            $filename = strtolower(preg_replace('/[^A-Za-z0-9_\-]/', "-", $image->getClientOriginalName())) . '.' . $extension;
            $image->move($path, $filename);

            $photo = Photo::create([
                'user_id' => $userId,
                'name' => $filename,
                'url_path' => env('APP_URL') . '/images/' . $categoryName . '/' . $filename,
                'photo_category_id' => $request->photo_category_id
            ]);

            return back()
                ->with('success', 'Photo was uploaded successfully!')
                ->with('photo', $photo);
        }
    }
}
