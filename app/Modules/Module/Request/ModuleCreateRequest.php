<?php

namespace App\Modules\Module\Request;

use App\Request\AppFormRequest;

class ModuleCreateRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "module.description" => ['required', 'string'],
            "module.name" => ['required', 'string'],
            "menu.name" => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            "module.description.required" => "Deskripsi dari module harus diisi",
            "module.name.required" => "Nama module harus diisi",
            "menu.name" => "Nama menu harus diisi",
        ];
    }
}
