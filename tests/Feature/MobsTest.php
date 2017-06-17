<?php

namespace Tests\Feature;

use App\Mob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MobsTest extends TestCase
{
    public function testMobRouteParams()
    {
        Mob::where('map_id', 1)
            ->where('x', 150)
            ->where('y', 150)
            ->get();
    }
}
