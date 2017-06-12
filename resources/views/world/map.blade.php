@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Elite-RPG Map
                    <span class="badge pull-right">@{{ playersInWorld.length }}</span>
                </div>

                <div class="panel-body">
                    <!-- Map.vue -->
                    {{--
                        v-for="map in maps"
                        :key="map.id"
                    --}}
                    <elite-map
                        v-for="map in maps"
                        :key="map.id"
                        :v-bind:map="map"
                        >
                    </elite-map>
                    <!-- PlayerMove.vue -->
                    <player-move
                        v-on:send="playerMove"
                        v-bind:direction="direction"
                        >
                    </player-move>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
