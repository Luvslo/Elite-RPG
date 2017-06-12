<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use App\Events\MessagePosted;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Message::with('user')->get();
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessagePosted($message, $user))->toOthers();

        return ['status' => 'OK'];
    }

}
