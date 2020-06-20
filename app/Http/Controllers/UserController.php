<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\EditPhotoFormRequest;
use App\Http\Requests\EditInfoUserFormRequest;
use App\Http\Requests\ChangePasswordFormRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = __('user.profile');
    }

    public function profile()
    {
        return view('profile', ['title' => $this->title]);
    }

    public function editPhoto(EditPhotoFormRequest $request)
    {              
        $user_id    = $request->input('user_id') ;
        $user       = User::find($user_id);

        if (!$user || !$user->checkUser($request->user())) {
            Alert::error(__('user.invalid_user'), __('user.messages.not_found'));
            return redirect()->route('user.profile');
        }

        $photo = $request->file('file')->store('photo', 'public');
        $user->setPhoto($photo);
        $user->save();
        
        Alert::Success(__('user.sucesso'), __("user.messages.photo_updated"));
        return redirect()->route('user.profile');
    }

    public function editInfo(EditInfoUserFormRequest $request)
    {
        $user_id    = $request->input('user_id') ;
        $user       = User::find($user_id);

        if (!$user || !$user->checkUser($request->user())) {
            Alert::error(__('user.invalid_user'), __('user.messages.not_found'));
            return redirect()->route('user.profile');
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        Alert::Success(__('user.sucesso'), __("user.messages.data_updated"));
        return redirect()->route('user.profile');
    }

    public function changePassword(ChangePasswordFormRequest $request) 
    {
        $user_id    = $request->input('user_id') ;
        $user       = User::find($user_id);

        if (!$user || !$user->checkUser($request->user())) {
            Alert::error(__('user.invalid_user'), __('user.messages.not_found'));
            return redirect()->route('user.profile');
        }
        
        if (!Hash::check($request->input('current_password'), $request->user()->password)) {
            Alert::error(__('user.invalid_password'), __('user.messages.incorrect_password'));
            return redirect()->route('user.profile');
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        Alert::Success(__('user.sucesso'), __("user.messages.password_changed"));
        return redirect()->route('user.profile');
    }

    public function getUsersJson(Request $request)
    {
        if ($request->input('query')) {
            $expression = $request->input('query');
            
            return User::where('name', 'like', "%{$expression}%")->get();
        }        

        return json_encode([]);
    }
}
