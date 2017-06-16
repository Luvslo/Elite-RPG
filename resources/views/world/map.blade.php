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


                    <div class="col-md-6">
                        <div class="row">
                        <strong>Room Name:</strong>
                        <!-- Map Component -->
                        <elite-map
                            v-for="map in maps"
                            :key="map.id"
                            :map="map"
                            >
                        </elite-map>
                    </div>
                    </div>

                    <!-- Mobs Component -->
                    <div class="col-md-4">
                        <strong>Mobs:</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>Room Desc</strong>
                    </div>
                </div>



                </div>
            </div>
        </div>
    </div>
</div>

@endsection
