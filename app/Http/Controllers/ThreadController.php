<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller {
     /* Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index($channelSlug = null)    {
        if($channelSlug) {
            $channelId = Channel::where('slug', $channelSlug)->first()->id;

            $threads = Thread::where('channel_id', $channelId)->latest()->get();
        } else {
            $threads = Thread::latest()->get();
        }
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Respons    */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'

        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'channel_id' => request('channel_id'),
            'body' => request('body'),

        ]);
        return redirect($thread->path());
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Thead  $thead
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thead  $thead
     * @return \Illuminate\Http\Response
     */
    public function edit(Thead $thead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thead  $thead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thead $thead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thead  $thead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thead $thead)
    {
        //
    }

}
