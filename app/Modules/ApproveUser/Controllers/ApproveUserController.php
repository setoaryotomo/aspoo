<?php

namespace App\Modules\ApproveUser\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\ApproveUser\Models\ApproveUser;
use App\Modules\ApproveUser\Repositories\ApproveUserRepository;
use App\Modules\ApproveUser\Requests\ApproveUserCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\PortalUser\Models\PortalUser;
use App\Modules\PortalUser\Models\TokoUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproveUserController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('ApproveUser::index', ['permissions' => $permissions]);
    }

    public function approve(Request $request,$id){
        $data = ApproveUser::find($id);
        $data->email_verified_at = date("Y-m-d H:i:s");
        $data->email_verifier_id = Auth::user()->id;
        $data->save();

        $userToko = TokoUser::create([
            'user_id' => $data->id,
            'nama' => $data->name,
        ]);

        $userPortal = PortalUser::where('user_id',$data->id)->first();

        $userPortal->password = $data->password;
        $userPortal->status = 1;
        $userPortal->approved_by = Auth::user()->id;
        $userPortal->approved_at = date("Y-m-d H:i:s");

        $userPortal->save();

        
        return JsonResponseHandler::setResult($data)->send();
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = ApproveUserRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('ApproveUser::create');
    }

    public function store(ApproveUserCreateRequest $request)
    {
        $payload = $request->all();
        $approve_user = ApproveUserRepository::create($payload);
        return JsonResponseHandler::setResult($approve_user)->send();
    }

    public function show(Request $request, $id)
    {
        $approve_user = ApproveUserRepository::get($id);
        return JsonResponseHandler::setResult($approve_user)->send();
    }

    public function edit($id)
    {
        return view('ApproveUser::edit', ['approve_user_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $approve_user = ApproveUserRepository::update($id, $payload);
        return JsonResponseHandler::setResult($approve_user)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = ApproveUserRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
