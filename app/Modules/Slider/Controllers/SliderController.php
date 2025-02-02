<?php

namespace App\Modules\Slider\Controllers;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Slider\Repositories\SliderRepository;
use App\Modules\Slider\Requests\SliderCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Slider::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = SliderRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Slider::create');
    }

    public function store(SliderCreateRequest $request)
    {
        $payload = $request->all();
        $payload['foto'] = FileHandler::store(file : $request->file('foto'), targetDir: "uploads/slider");
        $payload['created_by'] = Auth::user()->id;
        $slider = SliderRepository::create($payload);
        return JsonResponseHandler::setResult($slider)->send();
    }

    public function show(Request $request, $id)
    {
        $slider = SliderRepository::get($id);
        return JsonResponseHandler::setResult($slider)->send();
    }

    public function edit($id)
    {
        return view('Slider::edit', ['slider_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $slider = SliderRepository::update($id, $payload);
        return JsonResponseHandler::setResult($slider)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = SliderRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
