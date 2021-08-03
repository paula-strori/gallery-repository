@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-md-6 px-0">
                            {{ __('Filter By Category here') }}
                        </div>
                        <div class="col-md-6 px-0 d-flex justify-content-end">
                            Show Bookmarked Only
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($photos as $photo)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pb-1">
                                    <a href="#" class="thumbnail">
                                        <img src="{{$photo->url_path}}" class="w-100 shadow-1-strong rounded" alt="photo">
                                    </a>
                                    <p class="my-0 d-flex justify-content-between">
                                        <label>Mersim Bakalli - Family</label>
                                        <span class="d-flex">
                                            <button class="btn btn-xs btn-link"><i class="fas fa-file-download"></i></button>
                                            <button class="btn btn-xs btn-link"><i class="far fa-bookmark"></i></i></button>
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
@endsection
