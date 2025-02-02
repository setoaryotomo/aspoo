<?php

namespace App\Modules\InputSCM\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\InputSCM\Repositories\AlamatRepository;
use App\Modules\InputSCM\Repositories\InputSCMRepository;
use App\Modules\InputSCM\Requests\InputSCMCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function provinsi(Request $request){
        $data = AlamatRepository::getProvinsi();
        return JsonResponseHandler::setResult($data)->send();
    }
    public function kota(Request $request,$data){
        $data = AlamatRepository::getKota($data);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function kecamatan(Request $request,$data){
        $data = AlamatRepository::getKecamatan($data);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function kelurahan(Request $request,$data){
        $data = AlamatRepository::getKelurahan($data);
        return JsonResponseHandler::setResult($data)->send();
    }
}