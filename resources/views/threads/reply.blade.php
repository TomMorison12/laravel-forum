<div class="panel panel-default">
    <div class="panel-heading">
        <a href="#">
            {{$reply->owner->name}}</a>
        said {{$reply->created_at->diffforHumans()}}</div>
    <div class="panel-body">
        {{$reply->body}}
    </div>
