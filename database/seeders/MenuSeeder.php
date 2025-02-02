<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert(
            [
                'id' => 1,
                'name' => 'Setting',
                'description' => 'Organize Setting'
            ],
        );
        DB::table('menus')->insert([
            [
                'id' => 2,
                'name' => 'User',
                'path' => 'user',
                'description' => 'Organize User',
                'parent_id' => 1,
                'module_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'Role',
                'path' => 'role',
                'description' => 'Organize Role',
                'parent_id' => 1,
                'module_id' => 2
            ],
            [
                'id' => 4,
                'name' => 'Menu',
                'path' => 'menu',
                'description' => 'Organize Menu',
                'parent_id' => 1,
                'module_id' => 3
            ],
            [
                'id' => 5,
                'name' => 'Permission',
                'path' => 'permission',
                'description' => 'Organize Permission',
                'parent_id' => 1,
                'module_id' => 4
            ],
            [
                'id' => 7,
                'name' => 'Master Data',
                'path' => null,
                'description' => 'Organize Permission',
                'parent_id' => null,
                'module_id' => null
            ],
            [
                'id' => 8,
                'name' => 'Employee',
                'path' => 'employee',
                'description' => 'Organize employee',
                'parent_id' => 7,
                'module_id' => 5
            ],
            [
                'id' => 10,
                'name' => 'Module',
                'path' => 'module',
                'description' => 'Organize module',
                'parent_id' => 1,
                'module_id' => 5
            ],
        ]);
    }
}
