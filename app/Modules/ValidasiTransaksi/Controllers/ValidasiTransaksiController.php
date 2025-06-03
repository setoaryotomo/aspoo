<?php

namespace App\Modules\ValidasiTransaksi\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\ApproveTransaksi\Models\Pengiriman;
use App\Modules\Pembelian\Repositories\WatZapRepository;
use App\Modules\ValidasiTransaksi\Repositories\ValidasiTransaksiRepository;
use App\Modules\ValidasiTransaksi\Requests\ValidasiTransaksiCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\Portal\Model\Rekening;
use App\Modules\Portal\Model\TransaksiMaster;
use App\Modules\Portal\Model\UserDetail;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ValidasiTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('ValidasiTransaksi::index', ['permissions' => $permissions]);
    }
    
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') ?: 15;
        $keyword = $request->input('keyword', '');
        $data = ValidasiTransaksiRepository::datatable($per_page, $keyword);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function deletePreview(Request $request,$kode){
        $datas= TransaksiBarang::where('kode_transaksi_master',$kode)->get();
        try{
            DB::beginTransaction();
            foreach($datas as $data){
                
                $data->status = 22;
                $data->save();
                
                Pengiriman::create([
                    'transaksi_id' => $data->id,
                    'status' => 22,
                    'keterangan' => $request->pesan,
                ]);

            }
            DB::commit();
            $return = [
                'status' => 200,
                'message' => "Berhasil menolak",
                'body' => $datas
            ];

        }catch(Exception $e){
            DB::rollBack();
            $return = [
                'status' => 400,
                'message' => $e->getMessage(),
            ];
        }
        return JsonResponseHandler::setResult($return)->send();
    }
    
    public function preview(Request $request, $kode){
        $data = TransaksiMaster::where('kode_transaksi',$kode)->with('transaksi')->first();
        $datas = TransaksiBarang::where('kode_transaksi_master', $data->kode_transaksi)
                    ->with(['pembeli', 'dataChildren.barang'])
                    ->get();
        $datauser = UserDetail::where('user_id', $datas[0]->pembeli->id)->with('userMaster')->first();            
        $rekening = Rekening::where('status',1)->first();
        return view('ValidasiTransaksi::preview',compact('data','rekening','datas','datauser'));
    }
    
    public function approve(Request $request, $kode) {
        $datas = TransaksiBarang::where('kode_transaksi_master', $kode)
                    ->with(['pembeli', 'dataChildren.barang'])
                    ->get();
    
        // Pastikan ada data transaksi
        if ($datas->isEmpty()) {
            return JsonResponseHandler::setResult([
                'status' => 404,
                'message' => 'Transaksi tidak ditemukan'
            ])->send();
        }
    
        // Ambil data pembeli (dari transaksi pertama)
        $pembeli = $datas[0]->pembeli;
        $datauser = UserDetail::where('user_id', $pembeli->id)->with('userMaster')->first();
    
        try {
            DB::beginTransaction();
            
            // Siapkan daftar item dari semua transaksi
            $itemsList = "";
            $i = 1;
            $totalBiaya = 0;
            
            foreach ($datas as $data) {
                // Update status setiap transaksi
                $data->status = 2;
                $data->save();
                
                // Hitung total biaya
                $totalBiaya += $data->total_biaya;
                
                // Tambahkan item ke daftar
                foreach ($data->dataChildren as $child) {
                    $barang = $child->barang;
                    $itemsList .= $i++ . ". " . $barang->nama_barang 
                               . " x" . $child->jumlah 
                               . " (" . number_format($child->harga, 0, ',', '.') . ")\n";
                }
                
                // Buat record pengiriman
                Pengiriman::create([
                    'transaksi_id' => $data->id,
                    'status' => 2,
                    'keterangan' => 'Transaksi telah divalidasi oleh ASPOO',
                ]);
            }
            
            // Format total biaya
            $totalBiayaFormatted = "Rp " . number_format($totalBiaya, 0, ',', '.');
            
            // Buat pesan WhatsApp
            $whatsappMessage = "Halo " . $pembeli->username . ",\n";
            $whatsappMessage .= "📦 *Detail Transaksi* #" . $kode . "\n\n";
            $whatsappMessage .= "📋 *Daftar Produk*:\n" . $itemsList . "\n";
            $whatsappMessage .= "💵 *Total Biaya*: " . $totalBiayaFormatted . "\n\n";
            $whatsappMessage .= "✅ *Status*: Transaksi telah divalidasi oleh ASPOO\n";
            $whatsappMessage .= "Terima kasih telah berbelanja dengan kami!";
            
            // Kirim WhatsApp
            $response = Http::withHeaders([
                'Authorization' => 'RNnk34zGgGPPxF7KLn8L',
            ])->post('https://api.fonnte.com/send', [
                'target' => $datauser->telepon,
                'message' => $whatsappMessage,
            ]);
    
            DB::commit();
            
            $result = [
                'status' => 200,
                'message' => 'Data berhasil disimpan dan notifikasi terkirim',
                'body' => $datas
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $result = [
                'status' => 400,
                'message' => $e->getMessage()
            ];
        }
        
        return JsonResponseHandler::setResult($result)->send();
    }
    
    public function create()
    {
        return view('ValidasiTransaksi::create');
    }
    
    public function store(ValidasiTransaksiCreateRequest $request)
    {
        $payload = $request->all();
        $validasi_transaksi = ValidasiTransaksiRepository::create($payload);
        return JsonResponseHandler::setResult($validasi_transaksi)->send();
    }
    
    public function show(Request $request, $id)
    {
        $validasi_transaksi = ValidasiTransaksiRepository::get($id);
        return JsonResponseHandler::setResult($validasi_transaksi)->send();
    }
    
    public function edit($id)
    {
        return view('ValidasiTransaksi::edit', ['validasi_transaksi_id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $validasi_transaksi = ValidasiTransaksiRepository::update($id, $payload);
        return JsonResponseHandler::setResult($validasi_transaksi)->send();
    }
    
    public function destroy(Request $request, $id)
    {
        $delete = ValidasiTransaksiRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
