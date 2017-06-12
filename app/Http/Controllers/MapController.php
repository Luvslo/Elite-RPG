<?php

namespace App\Http\Controllers;

use Auth;
use App\Map;
use App\User;
use App\Events\PlayerMoving;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        return view('world.map');
    }

    public function show()
    {
        $map = Map::find(1);
        return response()->json($map->image);
    }

    public function update()
    {
        $map = Map::find(1);

        $user = User::find(Auth::user()->id);

        broadcast(new PlayerMoving($map, $user))->toOthers();

        //return response()->json([$map->image]);
    }
}
