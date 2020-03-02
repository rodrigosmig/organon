<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = 'Profile';
    }

    public function profile()
    {
        return view('profile', ['title' => $this->title]);
    }

    public function editPhoto(Request $request)
    {
        if (!User::validatePhoto($request->all())) {
            return redirect()->route('user.profile');
        }
               
        $user_id    = $request->input('user_id') ;
        $user       = User::find($user_id);

        if (!$user || !$user->checkUser($request->user())) {
            Alert::error(__('Invalid User.'), __('User not found.'));
            return redirect()->route('user.profile');
        }

        $user->deletePhoto($user->photo);

        $photo = $request->file('file')->store('photo', 'public');
        $user->photo = $photo;
        $user->save();
        
        Alert::Success('Success', __("Photo changed successfully"));
        return redirect()->route('user.profile');
    }

    public function editInfo(Request $request)
    {
        if (!User::validateInfo($request->all(), $request->user())) {
            return redirect()->route('user.profile');
        }
        
        $user_id    = $request->input('user_id') ;
        $user       = User::find($user_id);

        if (!$user || !$user->checkUser($request->user())) {
            Alert::error(__('Invalid User.'), __('User not found.'));
            return redirect()->route('user.profile');
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        Alert::Success('Success', __("Successfully changed data"));
        return redirect()->route('user.profile');
    }

    public function changePassword(Request $request) 
    {
        if (!User::validatePassword($request->all(), $request->user())) {
            return redirect()->route('user.profile');
        }

        $user_id    = $request->input('user_id') ;
        $user       = User::find($user_id);

        if (!$user || !$user->checkUser($request->user())) {
            Alert::error(__('Invalid User.'), __('User not found.'));
            return redirect()->route('user.profile');
        }
        
        if (!Hash::check($request->input('current_password'), $request->user()->password)) {
            Alert::error(__('Invalid Password.'), __('Current password is incorrect.'));
            return redirect()->route('user.profile');
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        Alert::Success('Success', __("password changed successfully"));
        return redirect()->route('user.profile');
    }
}
