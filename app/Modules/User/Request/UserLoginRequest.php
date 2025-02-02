<?php

namespace App\Modules\User\Request;

use App\Request\AppFormRequest;

class UserLoginRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }
}
