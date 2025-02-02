<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('module')->insert([
            [
                'id' => 1,
                'name' => 'User',
                'description' => 'User Module'
            ],
            [
                'id' => 2,
                'name' => 'Role',
                'description' => 'Role Module'
            ],
            [
                'id' => 3,
                'name' => 'Menu',
                'description' => 'Menu Module'
            ],
            [
                'id' => 4,
                'name' => 'Permission',
                'description' => 'Permission Module'
            ],
            [
                'id' => 5,
                'name' => 'Module',
                'description' => 'Module Module'
            ],
            [
                'id' => 6,
                'name' => 'Employee',
                'description' => 'Employee Module'
            ],
        ]);
    }
}
