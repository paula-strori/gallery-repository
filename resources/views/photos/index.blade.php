@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-md-6 px-0">
                            {{ __('Filter By Category here') }}
                            <select class="form-select" id="photo-category-select" name="photo_category_id" aria-label="Default select example" onchange="filterPhotos('{{$filterBookmarked}}')">
                                <option value="-1" selected>No Category</option>
                                @foreach ($photoCategories as $category)
                                    <option value="{{$category->id}}" {{ ($filterCategory==$category->id) ? 'selected' : ""}} >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 px-0 d-flex justify-content-end">
                            <button class="btn {{$filterBookmarked=="all" ? "btn-primary" : "btn-link" }} btn-sm" onclick="filterPhotos('{{$filterBookmarked}}')">Show Bookmarked Only</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($photos as $photo)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pb-1">
                                    <a href="#" class="thumbnail">
                                        <img src="{{$photo->url_path}}" class="w-100 border shadow-1-strong rounded" alt="photo">
                                    </a>
                                    <p class="my-0 d-flex justify-content-between">
                                        <label class="mb-0 d-flex align-items-center" style="color: #808080">{{$photo->user->name}} {{$photo->user->surname}} - {{ ($photo->category) ? $photo->category->name : ""}}</label>
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

        function filterPhotos(bookmarked){
            var catValue = document.getElementById('photo-category-select').value
            var filterURLPart = ""
            if (catValue > 0) {
                filterURLPart = "?category=" + catValue
                if(bookmarked == "all"){
                    filterURLPart += "&bookmarked"
                }
            } else if (bookmarked == "onlyBookmarked"){
                filterURLPart = "?bookmarked"
            }
            var url = "/photos" + filterURLPart
            window.open(url, '_self')
        }
    </script>
@endsection
