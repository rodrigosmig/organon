@extends('layouts.front')

@section('link-css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('script-js')
    <script src="{{ asset('js/profile.js' )}}" type="text/javascript"></script>
@endsection

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="card-title mb-4">
                        <div class="d-flex justify-content-start">
                            <div class="image-container">
                                <form id="formEditPhoto" action="{{ route('user.edit-photo') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    @if (auth()->user()->photo == 'user.png')
                                        <img src="{{ asset('img/user.png') }}" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
                                    @else
                                        <img src="/storage/{{auth()->user()->photo}}" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
                                    @endif
                                    
                                    <div class="middle">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <input type="button" class="btn btn-secondary" id="btnChangePicture" value="Change" />
                                        <input type="file" style="display: none;" id="profilePicture" name="file" />
                                    </div>
                                </form>
                            </div>
                            <div class="userData ml-3">
                                <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);">{{ auth()->user()->name }}</a></h2>
                                <h4 class="d-block" style="font-size: 0.8rem; font-weight: bold"><a href="javascript:void(0);">{{ auth()->user()->email }}</a></h4>
                                <h6 class="d-block">{{ auth()->user()->countProjects() }} Projects</h6>
                                <h6 class="d-block">{{ auth()->user()->countTasks() }} Tasks</h6>
                            </div>
                            <div class="ml-auto">
                                <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="{{ __('Discard Changes') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">{{ __('Basic Info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="Password" aria-selected="false">{{ __('Change Password') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content ml-1" id="myTabContent">
                                <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                    <form action="{{ route('user.edit-info') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <div class="form-group">
                                            <label for="user_name">{{ __('Name') }}</label>
                                            <input type="text" class="form-control" id="User_name" name="name" required value="{{ auth()->user()->name }}">
                                        </div>
    
                                        <div class="form-group">
                                            <label for="user_email">{{ __('E-mail') }}</label>
                                            <input type="email" class="form-control" id="user_email" name="email" required value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="Password-tab">
                                    <form action="{{ route('user.change-password') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <div class="form-group">
                                            <label for="current_password">{{ __('Current Password') }}</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="new_password">{{ __('New Password') }}</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="confirm_password">{{ __('Confirm Password') }}</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        </div>
    
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection