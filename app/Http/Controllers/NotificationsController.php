<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);

        //标记为已读，未读数量改为 0
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
