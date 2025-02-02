<?php

namespace App\Modules\Menu\Repository;

use App\Modules\Menu\Model\MenuModel;
use App\Modules\Module\Model\ModuleModel;
use App\Modules\Permission\Model\PermissionModel;
use Illuminate\Support\Facades\File;

class MenuRepository
{
    public static function generateMenu($menu_payload)
    {
        self::store($menu_payload);
        $module = ModuleModel::where('id', $menu_payload['module_id'])->first();
        if ($module != null) {
            $module_name = join("", explode(" ", $module->name));
            $module_path = app_path() . '/Modules' . '/' . $module_name;
            $menu_title = $menu_payload['name'];
            $menu_name = join("", explode(" ", $menu_payload['name']));
            $menu_path = strtolower(join("-", explode(" ", $menu_payload['name'])));

            // TODO : Generate Controller
            self::generateController($module_path, $module_name, $menu_name, $menu_path);

            // TODO : Generate route
            self::generateRoute($module_name, $menu_name, $menu_path);

            // TODO : Generate index file
            self::generateIndexFile($module_path, $menu_path, $menu_title);
        }
    }

    private static function generateController($module_path, $module_name, $menu_name, $menu_path)
    {
        $controller_string = File::get(base_path() . "/template/ControllerMenu.php");
        $controller_string = str_replace('module_name', $module_name, $controller_string);
        $controller_string = str_replace('menu_name', $menu_name, $controller_string);
        $controller_string = str_replace('menu_path', $menu_path, $controller_string);

        File::put($module_path . '/Controllers//' . $menu_name . 'Controller.php', $controller_string);
    }

    private static function generateRoute($module_name, $menu_name, $menu_path)
    {
        // Generate use
        $file_path = base_path()  . "/app/Modules/$module_name/routes.php";
        $search_string = "// USE MARKER (DONT DELETE THIS LINE)";
        $insert_string = "use App\Modules\\{$module_name}\Controllers\\{$menu_name}Controller;\n";
        $file_lines = file($file_path);
        $matched_line_index = 18;
        foreach ($file_lines as $index => $line) {
            if (str_contains($line, $search_string)) {
                $matched_line_index = $index;
            }
        }

        array_splice($file_lines, $matched_line_index, 0, $insert_string);
        $modified_file_contents = implode("", $file_lines);
        file_put_contents($file_path, $modified_file_contents);

        // Generate route prefix
        $file_lines = file($file_path);
        $file_path = base_path()  . "/app/Modules/{$module_name}/routes.php";
        $search_string = "// SUB MENU MARKER (DONT DELETE THIS LINE)";
        $insert_string = <<<END
            Route::prefix('/{$menu_path}')->group(function() {
                Route::get('/', [{$menu_name}Controller::class, 'index']);
            });\n
        END;
        $file_lines = file($file_path);
        $matched_line_index = 18;
        foreach ($file_lines as $index => $line) {
            if (str_contains($line, $search_string)) {
                $matched_line_index = $index;
            }
        }

        array_splice($file_lines, $matched_line_index, 0, $insert_string);
        $modified_file_contents = implode("", $file_lines);
        file_put_contents($file_path, $modified_file_contents);
    }

    private static function generateIndexFile($module_path, $menu_path, $menu_title)
    {
        File::makeDirectory($module_path . '/Views//' . $menu_path, 0755);

        $index_string = <<<END
        @extends('dashboard_layout.index')
        @section('content')
        <div class="page-inner" id="{$menu_path}">
            <div class="card">
                <div class="card-header">
                    <h1>{$menu_title}</h1>
                </div>
                <div class="card-body">
                    <h2> Some Content</h2>
                </div>
            </div>
        </div>
        @endsection
        END;
        File::put($module_path . "/Views/{$menu_path}/" . "index.blade.php", $index_string);
    }

    public static function store($menu_payload)
    {
        $menu = MenuModel::create($menu_payload);
        $menu_code = strtolower(join("_", explode(" ", $menu->name)));
        $permission_payload = [
            [
                'code' => 'create-' . $menu_code,
                'description' => 'Create ' . $menu->name,
                'menu_id' => $menu->id
            ],
            [
                'code' => 'read-' . $menu_code,
                'description' => 'Read ' . $menu->name,
                'menu_id' => $menu->id
            ],
            [
                'code' => 'update-' . $menu_code,
                'description' => 'Update ' . $menu->name,
                'menu_id' => $menu->id
            ],
            [
                'code' => 'delete-' . $menu_code,
                'description' => 'Delete ' . $menu->name,
                'menu_id' => $menu->id
            ]
        ];
        PermissionModel::insert($permission_payload);
        return $menu;
    }
}
