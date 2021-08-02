<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($userId)
    {
        $userProfile = User::findOrFail($userId);

        return view('users.show', compact('userProfile'));
    }

    public function edit($userId)
    {
        $userProfile = User::findOrFail($userId);

        return view('users.edit', compact('userProfile'));
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

        return back()->with('success', 'User Profile was updated successfully!');
    }

    public function addPhoto(Request $request, $userId)
    {
        $categoryName = Photo::CATEGORIES[$request->category_id];
        if ( $request->hasFile('img')){
            $path = storage_path('app/'.$categoryName);
            $image = $request->img;
            $extension = $image->getClientOriginalExtension();
            $filename = strtolower($image->getClientOriginalName()).'.'.$extension;
            $image->move($path,$filename);

            $photo = Photo::create([
                'user_id' => $userId,
                'name' => $filename,
                'url_path' => $path,
                'category_id' => $request->category_id
            ]);

            return back()
                ->with('success', 'Photo was uploaded successfully!')
                ->with('photo', $photo);
        }
    }

    public function myPhotos(Request $request, $userId)
    {
        $myPhotos = Photo::with('userBookmarks')->where('user_id', $userId);

        if ($request->has('category_id')) {
            $myPhotos->where('category_id', $request->category_id);
        }
        $myPhotos->orderBy('created_at', 'desc')
            ->get();

        return view('users.myPhotos', compact('myPhotos'));
    }
}
