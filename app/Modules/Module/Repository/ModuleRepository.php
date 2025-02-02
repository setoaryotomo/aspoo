<?php

namespace App\Modules\Module\Repository;

use App\Modules\Menu\Repository\MenuRepository;
use App\Modules\Module\Model\ModuleModel;
use Illuminate\Support\Facades\File;

class ModuleRepository
{
    public static function create($module_payload, $menu_payload, $property_payload)
    {
        // TODO : Create module data
        $module = ModuleModel::create($module_payload);

        // TODO : create menu data
        $menu_payload['module_id'] = $module->id;
        $menu = MenuRepository::store($menu_payload);

        // TODO : Create module and menu file
        self::generateModuleFile($module_payload, $menu_payload, $property_payload);
    }
    public static function generateModuleFile($module_payload, $menu_payload, $property_payload)
    {
        $module_name = join("", explode(" ", $module_payload['name'])); // Patter must Be ModuleName, Employee, UserPreferences, modulename
        $module_url = strtolower(join("-", explode(" ", $module_payload['name']))); // module-name, employee, user-preferences
        $module_variable = strtolower(join("_", explode(" ", $module_payload['name']))); // module_name, employee, user_preferences
        $menu_permission_code = strtolower(join("_", explode(" ", $menu_payload['name']))); // module_name, employee, user_preferences
        $module_path = app_path() . '/Modules' . '/' . $module_name; // returning app/Modules/$module_name
        // Generate Folder
        self::generateFolder($module_path);
        // Generate Route
        self::generateRoute($module_name, $module_url, $module_variable, $module_path, $menu_permission_code);
        // Create DB Migration
        if (count($property_payload) > 0) {
            self::generateMigration($module_variable, $property_payload);
        }
        // Create Model
        self::generateModel($module_name, $module_variable, $module_path);
        // Create Repository
        self::generateRepository($module_name, $module_variable, $module_path);
        // Create Request
        self::generateRequest($module_name, $module_path, $property_payload);
        // Create Controller
        self::generateController($module_name, $module_variable, $module_path);
        // Create View
        self::generateView($module_name, $module_url, $module_variable, $module_path, $property_payload, $menu_permission_code);
    }
    private static function generateFolder($module_path)
    {

        if (!File::exists($module_path)) {
            File::makeDirectory($module_path, 0755, true);
        }
        File::makeDirectory($module_path . '/Models', 0755);
        File::makeDirectory($module_path . '/Repositories', 0755);
        File::makeDirectory($module_path . '/Requests', 0755);
        File::makeDirectory($module_path . '/Controllers', 0755);
        File::makeDirectory($module_path . '/Views', 0755);
    }
    private static function generateMigration($module_variable, $property_payload)
    {
        $migration_string = <<<END
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;
        
        return new class extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('{$module_variable}', function (Blueprint \$table) {
        END;
        $migration_string = $migration_string . "\n\t\t\t\$table->id();";

        foreach ($property_payload as $property) {
            $type = $property['type'];
            $name = $property['name'];
            $length = $property['length'] != null ? $property['length'] : 255;

            if ($type == 'double') {
                $migration_string = $migration_string . "\n\t\t\t\$table->$type('$name', 10, $length);";
            } else if ($type == 'decimal') {
                $migration_string = $migration_string . "\n\t\t\t\$table->$type('$name', \$precision = $length, \$scale = 8);";
            } else if ($type == 'string') {
                $migration_string = $migration_string . "\n\t\t\t\$table->$type('$name', $length);";
            } else {
                $migration_string = $migration_string . "\n\t\t\t\$table->$type('$name');";
            }
        }
        $migration_string = $migration_string . "\n\$table->timestamps();";
        $migration_string = $migration_string . "\n\$table->softDeletes();";
        $migration_string = $migration_string . <<<END
                \n\t\t});
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('{$module_variable}');
            }
        };
        END;
        File::put(base_path() . '/database/migrations/' . date('Y_m_d_His') . "_create_{$module_variable}_table.php", $migration_string);
    }
    private static function generateRoute($module_name, $module_url, $module_variable, $module_path, $menu_permission_code)
    {
        // creating routes.php in module
        $route_string = <<<END
        <?php
        namespace App\Modules\\{$module_name};

        use App\Modules\\{$module_name}\Controllers\\{$module_name}Controller;
        use Illuminate\Support\Facades\Route;
        
        // USE MARKER (DONT DELETE THIS LINE)

        Route::prefix('/{$module_url}')->group(function() {

            // SUB MENU MARKER (DONT DELETE THIS LINE)

            Route::get('/', [{$module_name}Controller::class, 'index'])->middleware('authorize:read-{$menu_permission_code}');
            Route::get('/datatable', [{$module_name}Controller::class, 'datatable'])->middleware('authorize:read-{$menu_permission_code}');
            Route::get('/create', [{$module_name}Controller::class, 'create'])->middleware('authorize:create-{$menu_permission_code}');
            Route::post('/', [{$module_name}Controller::class, 'store'])->middleware('authorize:create-{$menu_permission_code}');
            Route::get('/{{$module_variable}_id}', [{$module_name}Controller::class, 'show'])->middleware('authorize:read-{$menu_permission_code}');
            Route::get('/{{$module_variable}_id}/edit', [{$module_name}Controller::class, 'edit'])->middleware('authorize:update-{$menu_permission_code}');
            Route::put('/{{$module_variable}_id}', [{$module_name}Controller::class, 'update'])->middleware('authorize:update-{$menu_permission_code}');
            Route::delete('/{{$module_variable}_id}', [{$module_name}Controller::class, 'destroy'])->middleware('authorize:delete-{$menu_permission_code}');
        });
        END;
        File::put($module_path . '/' . 'routes.php', $route_string);

        // require above file in routes/web.php
        $file_path = base_path()  . "/routes/web.php";
        $search_string = "ROUTE_MARKER";
        $insert_string = "    require app_path('Modules/{$module_name}/routes.php');\n";

        $file_lines = file($file_path);

        $matched_line_index = 18;
        foreach ($file_lines as $index => $line) {
            if (str_contains($line, $search_string)) {
                $matched_line_index = $index;
            }
        }

        array_splice($file_lines, $matched_line_index - 1, 0, $insert_string);
        $modified_file_contents = implode("", $file_lines);
        file_put_contents($file_path, $modified_file_contents);
    }

    private static function generateModel($module_name, $module_variable, $module_path)
    {
        $model_string = File::get(base_path() . "/template/Model.php");
        $model_string = str_replace('module_name', $module_name, $model_string);
        $model_string = str_replace('module_variable', $module_variable, $model_string);
        File::put($module_path . '/Models//' . $module_name . '.php', $model_string);
    }

    private static function generateRepository($module_name, $module_variable, $module_path)
    {
        $repository_string = File::get(base_path() . "/template/Repository.php");
        $repository_string = str_replace('module_name', $module_name, $repository_string);
        $repository_string = str_replace('module_variable', $module_variable, $repository_string);
        File::put($module_path . '/Repositories//' . $module_name . 'Repository.php', $repository_string);
    }

    private static function generateController($module_name, $module_variable, $module_path)
    {
        $controller_string = File::get(base_path() . "/template/Controller.php");
        $controller_string = str_replace('module_name', $module_name, $controller_string);
        $controller_string = str_replace('module_variable', $module_variable, $controller_string);

        File::put($module_path . '/Controllers//' . $module_name . 'Controller.php', $controller_string);
    }

    public static function generateRequest($module_name, $module_path, $property_payload)
    {
        $request_string = File::get(base_path() . "/template/Request.php");
        $request_string = <<<END
        <?php

        namespace App\Modules\\{$module_name}\Requests;

        use App\Request\AppFormRequest;


        class {$module_name}CreateRequest extends AppFormRequest
        {
            public function rules(): array
            {
                return [
        END;

        foreach($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $request_string = $request_string . "\n\t\t\t\t'{$property_name}' => 'required',";
        }

        $request_string = $request_string . <<<END
        \n\t\t\t];
            }

            public function messages(): array
            {
                return [
                    
                
        END;

        foreach($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $request_string = $request_string . "\n\t\t\t\t'{$property_name}.required' => '{$property_label} tidak boleh kosong',";
        }

        $request_string = $request_string . <<<END
        \n\t\t\t];
            }

        }     
        END;
        $request_string = str_replace('module_name', $module_name, $request_string);
        File::put($module_path . '/Requests//' . $module_name . 'CreateRequest.php', $request_string);
    }

    private static function generateView($module_name, $module_url, $module_variable, $module_path, $property_payload, $menu_permission_code)
    {
        // Generate Service Provider
        self::generateServiceProvider($module_name);
        // Generate Index
        self::generateIndexView($module_name, $module_url, $module_variable, $module_path, $property_payload, $menu_permission_code);
        // Generate Create
        self::generateCreateView($module_name, $module_url, $module_variable, $module_path, $property_payload);
        // Generate Edit
        self::generateEditView($module_name, $module_url, $module_variable, $module_path, $property_payload);
    }
    private static function generateServiceProvider($module_name)
    {
        // require above file in routes/web.php
        $file_path = base_path()  . "/app/Providers/ModuleViewServiceProvider.php";
        $search_string = "VIEW_MARKER";
        $insert_string = "        \$this->loadViewsFrom(__DIR__.'/../Modules/{$module_name}/Views', '{$module_name}');\n";

        $file_lines = file($file_path);

        $matched_line_index = 18;
        foreach ($file_lines as $index => $line) {
            if (str_contains($line, $search_string)) {
                $matched_line_index = $index;
            }
        }

        array_splice($file_lines, $matched_line_index - 1, 0, $insert_string);
        $modified_file_contents = implode("", $file_lines);
        file_put_contents($file_path, $modified_file_contents);
    }
    private static function generateIndexView($module_name, $module_url, $module_variable, $module_path, $property_payload, $menu_permission_code)
    {
        $index_string = <<<END
        @extends('dashboard_layout.index')
        @section('content')
        <div class="page-inner" id="{$module_url}">
            <default-datatable title="{$module_name}" url="{!! url('{$module_url}') !!}" :headers="headers" :can-add="{{ \$permissions['create-{$menu_permission_code}'] }}" :can-edit="{{ \$permissions['update-{$menu_permission_code}'] }}" :can-delete="{{ \$permissions['delete-{$menu_permission_code}'] }}" />
        </div>

        <script>
            createApp({
                data() {
                    return {
                        headers: [
                            {
                                text: 'Id',
                                value: 'id',
                            },
        END;

        foreach ($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $index_string = $index_string . <<<END
                \n\t\t\t\t\t{
                    \t\t\t\t\t\tvalue: '{$property_name}',
                    \t\t\t\t\t\ttext: '{$property_label}'
                \t\t\t\t\t},
            END;
        }


        $index_string = $index_string . <<<END
            \n\t\t\t\t\t],
                    }
                },
                created() {},
                methods: {},
                components: {
                    ...commonComponentMap(
                        [
                            'DefaultDatatable',
                        ]
                    )
                },
            }).mount('#{$module_url}');
        </script>
        @endsection
        END;
        File::put($module_path . '/Views//' . 'index.blade.php', $index_string);
    }

    private static function generateCreateView($module_name, $module_url, $module_variable, $module_path, $property_payload)
    {
        $haveCheckbox = false;
        $haveSelect = false;
        $haveRadio = false;
        $create_string = <<<END
        @extends('dashboard_layout.index')
        @section('content')
        <div class="page-inner">
            <div id="add-{$module_url}" class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Tambah {$module_name}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form ref="{$module_variable}_form">
                        <div class="row">
        END;

        foreach ($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $property_type = $property["input_type"];
            if ($property_type == "PASSWORD") {
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <input v-model="{$module_variable}.{$property_name}" class="form-control" type="password">
                                    </div>
                                </div>
                END;
            } else if ($property_type == "TEXTAREA") {
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <textarea v-model="{$module_variable}.{$property_name}" class="form-control"></textarea>
                                    </div>
                                </div>
                END;
            } else if ($property_type == "INPUT-NUMBER") {
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <input v-model="{$module_variable}.{$property_name}" class="form-control" type="number">
                                    </div>
                                </div>
                END;
            } else if ($property_type == "CHECKBOX") {
                $haveCheckbox = true;
                $checkboxLabel = $property_name;
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <div class="checkbox row">
                                            <label class="col-auto">
                                                <input type="checkbox" true-value=1 v-model="{$module_variable}.{$property_name}"> 
                                                Check
                                            </label>
                                        </div>
                                    </div>
                                </div>
                END;
            } else if ($property_type == "RADIO") {
                $haveRadio = true;
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <div class="radio row">
                                            <label v-for="(radio, index) in radioOptions" class="col-auto">
                                                <input type="radio" :name="radio.id+index" :value="radio.id" v-model="{$module_variable}.{$property_name}"> 
                                                @{{ radio.label }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                END;
            } else if ($property_type == "SELECT") {
                $haveSelect = true;
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <vue-multiselect v-model="{$module_variable}.{$property_name}" :searchable="true" :options="selectOptions"
                                                placeholder="Pilih Opsi" />
                                    </div>
                                </div>
                END;
            } else {
                $create_string = $create_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <input v-model="{$module_variable}.{$property_name}" class="form-control" type="text">
                                    </div>
                                </div>
                END;
            }
        }

        $create_string = $create_string . <<<END
        \n
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" @click="back" class="btn btn-sm bg-warning mr-2 text-white">
                                Cancel
                            </button>
                            <button type="button" @click="store" class="btn btn-sm bg-primary mr-2 text-white">
                                Save Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            Vue.createApp({
                data() {
                    return {
                        {$module_variable}: {
        END;

        foreach ($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $property_type = $property["input_type"];
            if ($property_type == "CHECKBOX") {
                $create_string = $create_string . "\n\t\t\t\t\t{$property_name}: 0,";
            } else {
                $create_string = $create_string . "\n\t\t\t\t\t{$property_name}: null,";
            }
        }

        $create_string = $create_string . <<<END
        \n
                        },
                        selectOptions: [
                            {
                                value: 1,
                                label: "Yes" 
                            },
                            {
                                value: 0,
                                label: "No"
                            }
                        ],
                        radioOptions: [
                            {
                                id: 1,
                                label: "Yes"
                            },
                            {
                                id: 0,
                                label: "No"
                            }
                        ],
                    }
                },
                methods: {
                    back() {
                        history.back()
                    },
                    resetForm(){
                        this.{$module_variable} = {
        END;

        foreach ($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $property_type = $property["input_type"];
            if ($property_type == "CHECKBOX") {
                $create_string = $create_string . "\n\t\t\t\t\t{$property_name}: 0,";
            } else {
                $create_string = $create_string . "\n\t\t\t\t\t{$property_name}: null,";
            }
        }

        $create_string = $create_string . <<<END
        \n              }
                        this.\$refs.{$module_variable}_form.reset()
                    },
                    async store() {
                        try {
                            showLoading()
                            const response = await httpClient.post("{!! url('{$module_url}') !!}", this.{$module_variable})
                            hideLoading()
                            showToast({
                                message: "Data berhasil ditambahkan"
                            })
                            this.resetForm()
                        } catch (err) {
                            hideLoading()
                            showToast({
                                message: err.message,
                                type: 'error'
                            })
                        }
                    }
                },
                components: {
                    'vue-multiselect': VueformMultiselect
                },
            }).mount("#add-{$module_url}")
        </script>
        @endsection
        END;
        File::put($module_path . '/Views//' . 'create.blade.php', $create_string);
    }

    private static function generateEditView($module_name, $module_url, $module_variable, $module_path, $property_payload)
    {
        $edit_string = <<<END
        @extends('dashboard_layout.index')
        @section('content')
        <div class="page-inner">
            <div id="edit-{$module_url}" class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Tambah {$module_name}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form ref="{$module_variable}_form">
                        <div class="row">
        END;

        foreach ($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $property_type = $property["input_type"];
            if ($property_type == "PASSWORD") {
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <input v-model="{$module_variable}.{$property_name}" class="form-control" type="password">
                                    </div>
                                </div>
                END;
            } else if ($property_type == "TEXTAREA") {
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <textarea v-model="{$module_variable}.{$property_name}" class="form-control"></textarea>
                                    </div>
                                </div>
                END;
            } else if ($property_type == "INPUT-NUMBER") {
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <input v-model="{$module_variable}.{$property_name}" class="form-control" type="number">
                                    </div>
                                </div>
                END;
            } else if ($property_type == "CHECKBOX") {
                $haveCheckbox = true;
                $checkboxLabel = $property_name;
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <div class="checkbox row">
                                            <label class="col-auto">
                                                <input type="checkbox" true-value=1 v-model="{$module_variable}.{$property_name}"> 
                                                 Check
                                            </label>
                                        </div>
                                    </div>
                                </div>
                END;
            } else if ($property_type == "RADIO") {
                $haveRadio = true;
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <div class="radio row">
                                            <label v-for="(radio, index) in radioOptions" class="col-auto">
                                                <input type="radio" :name="radio.id+index" :value="radio.id" v-model="{$module_variable}.{$property_name}"> 
                                                @{{ radio.label }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                END;
            } else if ($property_type == "SELECT") {
                $haveSelect = true;
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <vue-multiselect v-model="{$module_variable}.{$property_name}" :selected="{$module_variable}.{$property_name}" :searchable="true" :options="selectOptions"
                                                placeholder="Pilih Opsi" />
                                    </div>
                                </div>
                END;
            } else {
                $edit_string = $edit_string . <<<END
                \n
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{$property_label}</label>
                                        <input v-model="{$module_variable}.{$property_name}" class="form-control" type="text">
                                    </div>
                                </div>
                END;
            }
        }

        $edit_string = $edit_string . <<<END
        \n
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" @click="back" class="btn btn-sm bg-warning mr-2 text-white">
                                Cancel
                            </button>
                            <button type="button" @click="update" class="btn btn-sm bg-primary mr-2 text-white">
                                Save Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            Vue.createApp({
                data() {
                    return {
                        {$module_variable}: {
        END;

        foreach ($property_payload as $property) {
            $property_name = $property["name"];
            $property_label = $property["label"];
            $property_type = $property["input_type"];
            if ($property_type == "CHECKBOX") {
                $edit_string = $edit_string . "\n\t\t\t\t\t{$property_name}: 0,";
            } else {
                $edit_string = $edit_string . "\n\t\t\t\t\t{$property_name}: null,";
            }
        }

        $edit_string = $edit_string . <<<END
        \n
                        },
                        selectOptions: [
                            {
                                value: 1,
                                label: "Yes" 
                            },
                            {
                                value: 0,
                                label: "No"
                            }
                        ],
                        radioOptions: [
                            {
                                id: 1,
                                label: "Yes"
                            },
                            {
                                id: 0,
                                label: "No"
                            }
                        ],
                    }
                },
                async created() {
                    showLoading()
                    await this.fetchData()
                    hideLoading()
                },
                methods: {
                    async fetchData() {
                        const response = await httpClient.get("{!! url('{$module_url}') !!}/{{ \${$module_variable}_id }}")
                        this.{$module_variable} = response.data.result
                        console.log(this.{$module_variable})
                    },
                    back() {
                        history.back()
                    },
                    async update() {
                        try {
                            showLoading()
                            const response = await httpClient.put("{!! url('{$module_url}') !!}/{{ \${$module_variable}_id }}",
                                this.{$module_variable})
                            hideLoading()
                            showToast({
                                message: "Data berhasil disimpan"
                            })
    
                        } catch (err) {
                            hideLoading()
                            showToast({
                                message: err.message,
                                type: 'error'
                            })
                        }
                    }
                },
                components: {
                    'vue-multiselect': VueformMultiselect
                },
            }).mount("#edit-{$module_url}")
        </script>
        @endsection
        END;
        File::put($module_path . '/Views//' . 'edit.blade.php', $edit_string);
    }
}
