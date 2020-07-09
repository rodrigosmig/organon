<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = __('notifications.notifications');
    }

    public function notifications()
    {
        $notifications = auth()->user()->unreadNotifications;

        return response()->json(compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        $notification = $request->user()
                            ->notifications()
                            ->where('id', $request->id)
                            ->first();

        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function all()
    {
        

        $data = [
            'notifications' => auth()->user()->notifications,
            'title'         => $this->title
        ];
        //dd($data);
        return view('notifications.index', $data);
    }
}
