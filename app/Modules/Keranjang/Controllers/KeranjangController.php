<?php

namespace App\Modules\Keranjang\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Keranjang\Models\Keranjang;
use App\Modules\Keranjang\Repositories\KeranjangRepository;
use App\Modules\Keranjang\Requests\KeranjangCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Keranjang::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = Keranjang::where('user_id',$user->id)->paginate($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Keranjang::create');
    }

    public function store(KeranjangCreateRequest $request)
    {
        $payload = $request->all();
        $payload['user_id'] = Auth::user()->id;
        $keranjang = KeranjangRepository::create($payload);
        return JsonResponseHandler::setResult($keranjang)->send();
    }

    public function show(Request $request, $id)
    {
        $keranjang = KeranjangRepository::get($id);
        return JsonResponseHandler::setResult($keranjang)->send();
    }

    public function edit($id)
    {
        return view('Keranjang::edit', ['keranjang_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $keranjang = KeranjangRepository::update($id, $payload);
        return JsonResponseHandler::setResult($keranjang)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = KeranjangRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
