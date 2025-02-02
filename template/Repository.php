<?php

namespace App\Modules\module_name\Repositories;

use App\Modules\module_name\Models\module_name;

class module_nameRepository
{
    public static function datatable($per_page = 15)
    {
        $data = module_name::paginate($per_page);
        return $data;
    }
    public static function get($module_variable_id)
    {
        $module_variable = module_name::where('id', $module_variable_id)->first();
        return $module_variable;
    }
    public static function create($module_variable)
    {
        $module_variable = module_name::create($module_variable);
        return $module_variable;
    }

    public static function update($module_variable_id, $module_variable)
    {
        module_name::where('id', $module_variable_id)->update($module_variable);
        $module_variable = module_name::where('id', $module_variable_id)->first();
        return $module_variable;
    }

    public static function delete($module_variable_id)
    {
        $delete = module_name::where('id', $module_variable_id)->delete();
        return $delete;
    }
}
