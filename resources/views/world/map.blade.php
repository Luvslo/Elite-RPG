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

                    <elite-map
                        v-for="map in maps"
                        :key="map.id"
                        :map="map"
                        >
                    </elite-map>
                    <elite-mobs
                        v-for="mob in mobs"
                        :key="mon.id"
                        :mob="mob"
                        >
                    </elite-mobs>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection
