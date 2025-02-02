<?php

namespace App\Modules\Presensi\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Presensi\Repositories\PresensiRepository;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class inputmanualController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Presensi::input-manual.index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = PresensiRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
}
