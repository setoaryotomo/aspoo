<?php

namespace App\Modules\cabang\Controllers;
use Illuminate\Http\Request;
use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\cabang\Models\cabang;
use App\Modules\cabang\Repositories\cabangRepository;
use App\Modules\cabang\Requests\cabangCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;

class cabangController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('cabang::index', ['permissions' => $permissions]);
    }
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = cabangRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('cabang::create');
    }

    public function store(cabangCreateRequest $request)
{
    $payload = $request->all();
    
    // Tambahkan user_id yang valid
    $payload['user_id'] = auth()->user()->id; // atau sumber lain untuk user_id
    
    $cabang = cabangRepository::create($payload);
    return JsonResponseHandler::setResult($cabang)->send();
}


    public function show(Request $request, $id)
    {
        $cabang = cabangRepository::get($id);
        return JsonResponseHandler::setResult($cabang)->send();
    }

    public function edit($id)
    {
        return view('cabang::edit', ['cabang_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $cabang = cabangRepository::update($id, $payload);
        return JsonResponseHandler::setResult($cabang)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = cabangRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }


}