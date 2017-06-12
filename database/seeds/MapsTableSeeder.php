<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class MapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maps')->insert([
            'image' => 'http://i.imgur.com/3YGdYRy.png',
            'name' => 'Map 1',
            'description' => 'Map 1 Description',
            'created_at' => Carbon::now()
        ]);
    }
}
