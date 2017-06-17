<?php

namespace App\Http\Controllers;

use App\Mob;
use Illuminate\Http\Request;

class MobController extends Controller
{

    public function index($id, $x, $y)
    {
        $mobs = Mob::where('map_id', $id)
            ->where('x', $x)
            ->where('y', $y)
            ->get();

        return response()->json($mobs);
    }

}
