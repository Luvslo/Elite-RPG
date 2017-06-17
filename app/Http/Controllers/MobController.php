<?php

namespace App\Http\Controllers;

use Auth;
use App\Mob;
use Illuminate\Http\Request;

class MobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, $x, $y)
    {
        $mobs = Mob::where('map_id', $id)
            ->where('x', $x)
            ->where('y', $y)
            ->get();

        return response()->json($mobs);
    }

}
