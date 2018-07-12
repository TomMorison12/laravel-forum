@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}</div>

                    <div class="panel-body">
                       {{$thread->body}}

                    </div>
                    <hr />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                    </div>
                @endforeach
            </div>
        </div>

        @if(auth()->check())
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form method="post" action="{{$thread->path(). '/reply'}}">
                    {{ csrf_field() }}
                    <div class="form-group">

                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                    </div>

                    <button type="submit" class="btn button-default">Submit</button>
                </form>

               </div>
        </div>
    </div>
            @else
            Please sign in to participate.
    @endif
@endsection
