<?php

namespace App\Modules\InputSCM\Controllers;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\InputSCM\Models\InputSCM;
use App\Modules\InputSCM\Models\UMKM;
use App\Modules\InputSCM\Repositories\InputSCMRepository;
use App\Modules\InputSCM\Requests\InputSCMCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputSCMController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('InputSCM::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $role = Auth::user()->role_ids[0];
        if($role == 1 || $role == 5){
            $data = UMKM::paginate($per_page);
            $data = UMKM::where('user_id',Auth::id())->paginate($per_page);
        }else{
            $data = UMKM::where('user_id',Auth::id())->paginate($per_page);
        }
        // $data = InputSCMRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function excel(Request $request){
        $data = UMKM::with(['kecamatan','kota','kelurahan','provinsi','barang','barang.bahan','barang.bahan.supplier'])->get();
     
        return JsonResponseHandler::setResult($data)->send();

    }

    public function create()
    {
        return view('InputSCM::create');
    }

    public function store(InputSCMCreateRequest $request)
    {
        $payload = $request->all();
        $payload['voice_file'] = FileHandler::store(file : $request->file("voice_file"),targetDir: "uploads/voice",allowedExtensions : ["mp3","m4a"]);
        $payload['user_id'] = Auth::user()->id;
        $input_scm = InputSCMRepository::create($payload);

        return JsonResponseHandler::setResult($input_scm)->send();
    }

    public function show(Request $request, $id)
    {
        $input_scm = InputSCMRepository::get($id);
        return JsonResponseHandler::setResult($input_scm)->send();
    }
    public function getEdit($id){
        $data = UMKM::where("id_umkm",$id)->first();
        return JsonResponseHandler::setResult($data)->send();
    }
    public function saveEdit(Request $request,$id){
        $data = UMKM::where("id_umkm",$id)->first();
        $payload = $request->all();
        $data->nama = $payload['nama'];
        $data->tahun_berdiri = $payload['tahun_berdiri'];
        $data->provinsi = $payload['provinsi'];
        $data->kota = $payload['kecamatan'];
        $data->kecamatan = $payload['kecamatan'];
        $data->kelurahan = $payload['kelurahan'];
        $data->alamat = $payload['alamat'];
        $data->koordinat = $payload['koordinat'];
        $data->jumlah_karyawan = $payload['jumlah_karyawan'];
        $data->jenis_ijin_usaha = $payload['jenis_ijin_usaha'];
        $data->ket_jenis_usaha = $payload['ket_jenis_usaha'];
        $data->omset_per_bulan = $payload['omset_per_bulan'];
        $data->permodalan = $payload['permodalan'];
        $data->ket_permodelan = $payload['ket_permodelan'];
        $data->legalitas = $payload['legalitas'];
        $data->kategori_usaha = $payload['kategori_usaha'];
        $data->ket_kategori_usaha = $payload['ket_kategori_usaha'];
        $data->transaksi_lokal = $payload['transaksi_lokal'];
        $data->transaksi_titipan = $payload['transaksi_titipan'];
        $data->area_penjualan = $payload['area_penjualan'];
        $data->jumlah_gerai = $payload['jumlah_gerai'];
        $data->voice_file = $payload['voice_file'];
        $data->voice_text = $payload['voice_text'];
        $data->save();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function edit($id)
    {
        return view('InputSCM::edit', ['input_scm_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $input_scm = InputSCMRepository::update($id, $payload);
        return JsonResponseHandler::setResult($input_scm)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = InputSCMRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
    public function preview(Request $request, $id)
    {
        $data = UMKM::where('id_umkm',$id)->with(['kecamatan','kota','kelurahan','provinsi','barang','barang.bahan','barang.bahan.supplier','barang.barang.user'])->first();
        
        return view('InputSCM::preview', ['data' => $data]); 
    }
}