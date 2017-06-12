@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Elite-RPG Chat <span class="badge pull-right">@{{ usersInRoom.length }}</span>
                </div>

                <div class="panel-body">

                    <chat-log v-bind:items="items"></chat-log>

                    <chat-compose v-on:send="sendMessage" :user="{{ Auth::user() }}"></chat-compose>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
