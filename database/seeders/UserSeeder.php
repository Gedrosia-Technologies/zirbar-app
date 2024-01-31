<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'isadmin' => true,
        ]);
        DB::table('parties')->insert([
            'name' => Str::random(10),
        ]);
        DB::table('stocks')->insert([
            'type' => 'Diesel',
            'liters' => 0.00,
            'sold' => 0.00,
            'remaining' => 0.00,
        ]);
        DB::table('stocks')->insert([
            'type' => 'Petrol',
            'liters' => 0.00,
            'sold' => 0.00,
            'remaining' => 0.00,
        ]);

        DB::table('units')->insert([
            'title' => 'unit1',
            'type' => 'Diesel',
            'counter' => 0.00,
            'rate' => 175.00,
        ]);
        DB::table('units')->insert([
            'title' => 'unit2',
            'type' => 'Petrol',
            'counter' => 0.00,
            'rate' => 175.00,
        ]);

    }
}
