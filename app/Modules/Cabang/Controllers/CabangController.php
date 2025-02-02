<?php

namespace App\Modules\Cabang\Controllers;
use Illuminate\Http\Request;
use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Cabang\Models\Cabang;
use App\Modules\Cabang\Repositories\CabangRepository;
use App\Modules\Cabang\Requests\CabangCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Cabang::index', ['permissions' => $permissions]);
    }
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = CabangRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Cabang::create');
    }

    public function store(CabangCreateRequest $request)
{
    $payload = $request->all();
    
    // Tambahkan user_id yang valid
    $payload['user_id'] = auth()->user()->id; // atau sumber lain untuk user_id
    
    $cabang = CabangRepository::create($payload);
    return JsonResponseHandler::setResult($cabang)->send();
}


    public function show(Request $request, $id)
    {
        $cabang = CabangRepository::get($id);
        return JsonResponseHandler::setResult($cabang)->send();
    }

    public function edit($id)
    {
        return view('Cabang::edit', ['cabang_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $cabang = CabangRepository::update($id, $payload);
        return JsonResponseHandler::setResult($cabang)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = CabangRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }


}