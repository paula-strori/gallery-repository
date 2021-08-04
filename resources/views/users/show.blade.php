@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="row d-flex justify-content-end px-3">
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-md-6 pl-0 d-flex align-items-center">
                            <h4 class="d-flex align-items-center mb-0">
                                {{$userProfile->name}} {{$userProfile->surname}}
                            </h4>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#editUserProfile">
                                Edit
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row mb-0">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{$userProfile->email}}">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{$userProfile->phone}}">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="address" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" value="{{$userProfile->address}}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <br>

                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-md-6 d-flex align-items-center">
                            <h4 class="d-flex align-items-center mb-0">
                                My Photos
                            </h4>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPhotoModal">
                                Add photo
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($userPhotos as $photo)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pb-1">
                                    <a href="#" class="thumbnail">
                                        <img src="{{$photo->url_path}}" class="w-100 shadow-1-strong rounded" alt="photo">
                                    </a>
                                    <p class="my-0 d-flex justify-content-between">
                                        <label class="d-flex align-items-center mb-0">{{$photo->category->name}}</label>
                                        <span class="d-flex">
                                        <a class="btn btn-xs btn-link" href="{{ route('photo-download', $photo->id) }}" target="_blank"><i class="fas fa-file-download"></i></a>
                                        <button class="btn btn-xs btn-link" data-photo-id = "{{$photo->id}}" onclick="bookmarkButtonClicked({{$photo->id}})"><i class="{{$photo->bookmarked ? "fas" : "far"}} fa-bookmark"></i></button>
                                    </span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addPhotoModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhotoModalLongTitle">Add New Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('user-add-photo', auth()->id()) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="photo">Choose Photo</label>
                            <input type="file" accept="image/*" name="img" class="form-control-file" id="photo">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Select Category</label>
                            <select class="form-select" name="photo_category_id" aria-label="Default select example">
                                <option selected>No Category</option>
                                @foreach ($photoCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary btn-sm">Add Photo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUserProfile" tabindex="-1" role="dialog" aria-labelledby="editUserProfileTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserProfileLongTitle">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('user-update', auth()->id()) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="user-Name" placeholder="Name" value="{{$userProfile->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input type="text" name="surname" class="form-control" id="user-surname" placeholder="Surname" value="{{$userProfile->surname}}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" id="user-phone" placeholder="phone" value="{{$userProfile->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" id="user-address" placeholder="Address" value="{{$userProfile->address}}">
                        </div>
                        <div class="form-group">
                            <label for="user-email">Email</label>
                            <input type="email" name="email" class="form-control" id="user-email" placeholder="Enter email" value="{{$userProfile->email}}" required>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bookmarkButtonClicked( photo_id ){
            $.ajax({
                'url': "/photos/" + photo_id + "/bookmark",
                'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                'type': 'POST',
                'error': function() {},
                'success': function (data) {
                    var buttonClicked = document.querySelector("[data-photo-id='" + photo_id + "']")
                    if(data == "Bookmarked"){
                        buttonClicked.innerHTML = "<i class='fas fa-bookmark'></i>"
                    } else {
                        buttonClicked.innerHTML = "<i class='far fa-bookmark'></i>"
                    }
                }
            })
        }
    </script>

@endsection
