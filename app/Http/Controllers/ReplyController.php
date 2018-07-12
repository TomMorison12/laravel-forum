<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use Auth;

class ReplyController extends Controller
{

    public function __construct() {
        $this->middleware('auth');

    }
    public function add($channelId, Thread $thread) {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => Auth::user()->id,

        ]);

        return back();
    }
}
