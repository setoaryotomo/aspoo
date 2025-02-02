<?php

namespace App\Modules\DataBarang\Controllers;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\DataBarang\Models\DataBarangKomposisi;
use App\Modules\DataBarang\Repositories\DataBarangRepository;
use App\Modules\DataBarang\Requests\DataBarangCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataBarangController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('DataBarang::index', ['permissions' => $permissions]);
    }

    public function findKodeBarang(Request $request){
        $page = (isset($request->page) ? $request->page :15);
        $data = DataBarang::where('kode_barang','LIKE',"%".$request->kode_barang."%")->paginate($page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function komposisi_index(Request $request,$id){

        return view('DataBarang::komposisi.index',['id' => $id]);

    }
    public function komposisi_datatable(Request $request,$id)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;

        $data = DataBarangKomposisi::where("id_barang",$id)->with('komposisi','komposisi.satuan')->paginate($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function komposisi_destroy(Request $request, $id, $id2){
        $data = DataBarangKomposisi::destroy($id2);
        return JsonResponseHandler::setResult($data)->send();

    }

    public function komposisi_create(Request $request,$id){

        return view('DataBarang::komposisi.create');

    }

    public function komposisi_store(Request $request, $id){
        $payload = $request->all();

        $data = DataBarangKomposisi::create([
            'id_komposisi' => $payload['id_komposisi'],
            'jumlah' => $payload['jumlah'],
            'id_barang' => $id,
        ]);



        return JsonResponseHandler::setResult($data)->send();
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $role = Auth::user()->role_ids[0];
        if($role == 1 || $role == 5){
            $data = DataBarang::with(['user','satuan'])->paginate($per_page);
        }else{
            $data = DataBarang::with(['user','satuan'])->where('created_by_user_id',Auth::id())->paginate($per_page);
        }

        return JsonResponseHandler::setResult($data)->send();
    }
    public function all(Request $request){
        $data = DataBarang::get();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('DataBarang::create');
    }

    public function view()
    {
        return view('DataBarang::view');
    }

    public function store(DataBarangCreateRequest $request)
    {
        $payload = $request->all();
        unset($payload['foto']);
        $foto = FileHandler::store(file : $request->file('foto'), targetDir: "uploads/".Auth::user()->id."/barang");
        $payload['created_by_user_id'] = Auth::user()->id;
        $payload['thumbnail'] = $foto;
        $data_barang = DataBarangRepository::create($payload);
        return JsonResponseHandler::setResult($data_barang)->send();
    }

    public function show(Request $request, $id)
    {
        $data_barang = DataBarangRepository::get($id);
        return JsonResponseHandler::setResult($data_barang)->send();
    }
    public function getEdit($data,$id)
    {
        $data = DataBarang::where("id_barang, $id")->fisrt();
        return JsonResponseHandler::setResult($data)->send();
    }
    public function edit($id)
    {
        return view('DataBarang::edit', ['barang_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();

        unset($payload['created_at']);
        unset($payload['updated_at']);
        unset($payload['deleted_at']);
        if($request->has('foto')){
            unset($payload['foto']);
            $foto = FileHandler::store(file : $request->file('foto'), targetDir: "uploads/".Auth::user()->id."/barang");
            $payload['thumbnail'] = $foto;
        }

        $data_barang = DataBarangRepository::update($payload['id'], $payload);
        return JsonResponseHandler::setResult($data_barang)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = DataBarangRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
