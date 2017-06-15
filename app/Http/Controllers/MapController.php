<?php

namespace App\Http\Controllers;

use Auth;
use App\Map;
use App\User;
use Illuminate\Http\Request;
use App\Events\PlayerMoving;

class MapController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('world.map');
    }

    public function show()
    {
        $map = Map::find(1);
        return response()->json($map->image);
    }

    public function map()
    {
        $map = Map::find(1);

        $user = User::find(Auth::user()->id);

        broadcast(new PlayerMoving($map, $user))->toOthers();

        return ['status' => 'OK'];

        //return response()->json([$map->image]);
    }
}
