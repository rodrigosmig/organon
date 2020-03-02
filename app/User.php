<?php

namespace App;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getFailMessages(Array $messages) :string
    {
        $fail_messages = "";
        foreach ($messages as $message) {
            $fail_messages .= $message . "\n";
        }
        
        Alert::warning(__('Warning'), $fail_messages)->autoclose(10000);
        
        return $fail_messages;
    }

    public function checkUser(User $user) :bool
    {
        if ($this->is($user)) {
            return true;
        }

        return false;
    }

    public static function validatePhoto(Array $data_user) :bool
    {
        $validator = Validator::make($data_user, [
            'user_id'   => 'required',
            'file'      => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {            
            User::getFailMessages($validator->messages()->all());
            
            return false;
        }

        return true;
    }

    public static function validateInfo(Array $data_user, User $user) :bool
    {
        $validator = Validator::make($data_user, [
            'user_id'   => 'required',
            'name'      => 'required',
            'email'     => [
                'required',
                'email',
                Rule::unique('users')->ignore($user)
            ]
        ]);

        if ($validator->fails()) {            
            User::getFailMessages($validator->messages()->all());
            return false;
        }

        return true;
    }

    public static function validatePassword(Array $data_user) :bool
    {
        $validator = Validator::make($data_user, [
            'user_id'           => 'required',
            'current_password'  => 'required',
            'new_password'      => 'required',
            'confirm_password'  => 'required|same:new_password'
        ]);

        if ($validator->fails()) {            
            User::getFailMessages($validator->messages()->all());
            return false;
        }

        return true;
    }

    public function deletePhoto(String $photo)
    {
        Storage::disk('public')->delete($photo);
        $this->photo = "user.png";
    }
}
