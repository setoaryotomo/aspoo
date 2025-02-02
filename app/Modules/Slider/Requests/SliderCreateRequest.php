<?php

namespace App\Modules\Slider\Requests;

use App\Request\AppFormRequest;


class SliderCreateRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
				'foto' => 'required',
				'keterangan' => 'required',
				'status' => 'required',
			];
    }

    public function messages(): array
    {
        return [
				'foto.required' => 'Foto tidak boleh kosong',
				'keterangan.required' => 'Keterangan tidak boleh kosong',
				'status.required' => 'Status tidak boleh kosong',
			];
    }

}     