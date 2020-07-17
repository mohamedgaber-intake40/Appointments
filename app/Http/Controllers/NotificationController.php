<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = $request->user()->profileable->notifications()->orderBy('created_at', 'desc')->paginate(20);
        return view('notifications.index',['notifications'=>$notifications]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$notification)
    {
        $notification = $request->user()->profileable->notifications()->find($notification);
        $appointment  = Appointment::find($notification->data['appointment_id']);
        if (!$notification->read_at)
			$notification->markAsRead();
        return view('notifications.show',['notification'=>$notification ,'appointment'=>$appointment ]);
    }

}
