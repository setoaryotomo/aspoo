<?php

namespace App\Modules\KategoriProduk\Requests;

use App\Request\AppFormRequest;


class KategoriProdukCreateRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
				'nama' => 'required',
			];
    }

    public function messages(): array
    {
        return [
            
        
				'nama.required' => 'Nama tidak boleh kosong',
			];
    }

}     