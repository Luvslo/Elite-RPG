<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mobs')->insert([
            'map_id' => 1,
            'name' => 'Testing Mob',
            'image' => 'default',
            'type' => 'mob',
            'x' => 150,
            'y' => 150,
            'spawn_at' => Carbon::now()->addMinutes(20),
            'description' => 'Mob testing description',
            'created_at' => Carbon::now(),
        ]);
    }
}
