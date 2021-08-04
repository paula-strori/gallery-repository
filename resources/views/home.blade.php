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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
