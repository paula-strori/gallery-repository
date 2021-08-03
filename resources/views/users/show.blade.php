@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-md-6">
                            <h4 class="d-flex align-items-center">
                                {{$userProfile->name}} {{$userProfile->surname}}
                            </h4>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <button class="btn btn-link">Edit</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row mb-0">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="email" value="{{$userProfile->email}}">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="phone" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="phone" value="{{$userProfile->phone}}">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="address" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="address" value="{{$userProfile->address}}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
