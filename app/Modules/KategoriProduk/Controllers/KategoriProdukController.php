<?php

namespace App\Modules\KategoriProduk\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\KategoriProduk\Models\PivotKategoriProduk;
use App\Modules\KategoriProduk\Repositories\KategoriProdukRepository;
use App\Modules\KategoriProduk\Requests\KategoriProdukCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriProdukController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('KategoriProduk::index', ['permissions' => $permissions]);
    }
    public function deletelistkategori($idkategori,$idbarang){
        $data = PivotKategoriProduk::where('id',$idbarang)->where('kategori_produk_id',$idkategori)->delete();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = KategoriProdukRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('KategoriProduk::create');
    }

    public function listkategori($id){
        $data = PivotKategoriProduk::where("kategori_produk_id",$id)->with("barang")->paginate(20);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function setkategori(Request $request){
        $payload = $request->all();
        try{
            DB::beginTransaction();
            foreach($payload['barang_id'] as $barang){
                $data = [
                    'barang_id' => $barang,
                    'kategori_produk_id' => $payload['kategori_produk_id']
                ];
                PivotKategoriProduk::create($data);
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return JsonResponseHandler::setResult($e)->send();
        }
        $data = ['status' => 'Berhasil!'];
        return JsonResponseHandler::setResult($data)->send();

    }
    public function store(KategoriProdukCreateRequest $request)
    {
        $payload = $request->all();
        $payload['created_by'] = Auth::user()->id;
        $kategoriproduk = KategoriProdukRepository::create($payload);
        return JsonResponseHandler::setResult($kategoriproduk)->send();
    }

    public function show(Request $request, $id)
    {
        $kategoriproduk = KategoriProdukRepository::get($id);
        return JsonResponseHandler::setResult($kategoriproduk)->send();
    }

    public function edit($id)
    {
        return view('KategoriProduk::edit', ['kategoriproduk_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $kategoriproduk = KategoriProdukRepository::update($id, $payload);
        return JsonResponseHandler::setResult($kategoriproduk)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = KategoriProdukRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
