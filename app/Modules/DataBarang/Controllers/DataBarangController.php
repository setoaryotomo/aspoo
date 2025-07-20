<?php

namespace App\Modules\DataBarang\Controllers;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\DataBarang\Models\DataBarangKomposisi;
use App\Modules\DataBarang\Models\InputStok;
use App\Modules\DataBarang\Repositories\DataBarangRepository;
use App\Modules\DataBarang\Requests\DataBarangCreateRequest;
use App\Modules\MasterUMKM\Models\MasterUMKM;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\PortalUser\Models\TokoUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DataBarangController extends Controller
{
    public function index(Request $request)
{
    $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
    
    // Get data for filters
    $produsenList = DataBarang::whereNotNull('produsen')
                    ->distinct()
                    ->pluck('produsen')
                    ->filter()
                    ->values();
    
    $umkmList = TokoUser::select('user_id', 'nama')
                ->whereNotNull('nama')
                ->get();

    $kategoriList = DataBarang::whereNotNull('kategori_umum')
                    ->distinct()
                    ->pluck('kategori_umum')
                    ->filter()
                    ->values();

    return view('DataBarang::index', [
        'permissions' => $permissions,
        'produsenList' => $produsenList,
        'umkmList' => $umkmList,
        'kategoriList' => $kategoriList
    ]);
}

    public function findKodeBarang(Request $request)
    {
        $page = (isset($request->page) ? $request->page : 15);
        $data = DataBarang::where('kode_barang', 'LIKE', "%" . $request->kode_barang . "%")->paginate($page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function komposisi_index(Request $request, $id)
    {
        return view('DataBarang::komposisi.index', ['id' => $id]);
    }

    public function komposisi_datatable(Request $request, $id)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = DataBarangKomposisi::where("id_barang", $id)->with('komposisi', 'komposisi.satuan')->paginate($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function komposisi_destroy(Request $request, $id, $id2)
    {
        $data = DataBarangKomposisi::destroy($id2);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function komposisi_create(Request $request, $id)
    {
        return view('DataBarang::komposisi.create');
    }

    public function komposisi_store(Request $request, $id)
    {
        $payload = $request->all();
        $data = DataBarangKomposisi::create([
            'id_komposisi' => $payload['id_komposisi'],
            'jumlah' => $payload['jumlah'],
            'id_barang' => $id,
        ]);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function inputstok_index(Request $request, $id)
    {
        return view('DataBarang::inputstok.index', ['id' => $id]);
    }

    public function inputstok_datatable(Request $request, $id)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = InputStok::where("id_barang_master", $id)->paginate($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function inputstok_destroy(Request $request, $id, $id2)
    {
        $data = InputStok::destroy($id2);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function inputstok_create(Request $request, $id)
    {
        return view('DataBarang::inputstok.create');
    }

    public function inputstok_store(Request $request, $id)
    {
        $payload = $request->all();
        $data = InputStok::create([
            'jumlah' => $payload['jumlah'],
            'tanggal' => $payload['tanggal'],
            'id_barang_master' => $id,
        ]);
        $barang = DataBarang::find($id);
        $barang->stock_global += $payload['jumlah'];
        $barang->save();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function datatable(Request $request)
{
    $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
    $keyword = $request->input('keyword', '');
    $role = Auth::user()->role_ids[0];

    $query = DataBarang::with(['user', 'satuan']);

    if ($role != 1 && $role != 5) {
        $query->where('created_by_user_id', Auth::id());
    }

    if (!empty($keyword)) {
        $query->where('nama_barang', 'LIKE', "%{$keyword}%");
    }

    // Apply filters
    if ($request->filled('produsen')) {
        $query->where('produsen', $request->produsen);
    }

    if ($request->filled('user_id')) {
        $query->where('created_by_user_id', $request->user_id);
    }

    if ($request->filled('kategori_umum')) {
        $query->where('kategori_umum', $request->kategori_umum);
    }

    $data = $query->orderByDesc('created_at')->paginate($per_page);
    return JsonResponseHandler::setResult($data)->send();
}

    public function all(Request $request)
    {
        $data = DataBarang::where(function($query) {
            $query->whereNull('scm_barang_id')
                  ->orWhere('scm_barang_id', '')
                  ->orWhere('scm_barang_id', '0');
        })->get();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function produsenAll(Request $request)
    {
        $produsen = DataBarang::select('produsen')->where('produsen', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($produsen)->send();
    }

    public function kategoriumumAll(Request $request)
    {
        $kategori_umum = DataBarang::select('kategori_umum')->where('kategori_umum', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($kategori_umum)->send();
    }
    public function kategorinamaAll(Request $request)
    {
        $kategori_nama = DataBarang::select('kategori_nama')->where('kategori_nama', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($kategori_nama)->send();
    }
    public function kategoriprodukAll(Request $request)
    {
        $kategori_produk = DataBarang::select('kategori_produk')->where('kategori_produk', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($kategori_produk)->send();
    }
    public function rasaAll(Request $request)
    {
        $rasa = DataBarang::select('rasa')->where('rasa', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($rasa)->send();
    }
    public function jeniskemasanAll(Request $request)
    {
        $jenis_kemasan = DataBarang::select('jenis_kemasan')->where('jenis_kemasan', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($jenis_kemasan)->send();
    }
    public function bahandasarAll(Request $request)
    {
        $bahan_dasar = DataBarang::select('bahan_dasar')->where('bahan_dasar', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($bahan_dasar)->send();
    }
    public function kekhasanAll(Request $request)
    {
        $kekhasan = DataBarang::select('kekhasan')->where('kekhasan', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($kekhasan)->send();
    }
    public function basahkeringAll(Request $request)
    {
        $basah_kering = DataBarang::select('basah_kering')->where('basah_kering', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($basah_kering)->send();
    }
    public function bahankemasanAll(Request $request)
    {
        $bahan_kemasan = DataBarang::select('bahan_kemasan')->where('bahan_kemasan', '!=', '')->distinct()->get();
        return JsonResponseHandler::setResult($bahan_kemasan)->send();
    }

    public function create()
    {
        return view('DataBarang::create');
    }

    public function createWithUserId($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return abort(404, 'User not found');
        }
        $umkm = MasterUMKM::where('user_id', $user_id)->first();
        return view('DataBarang::create', ['specified_user_id' => $user_id, 'umkm' => $umkm]);
    }

    public function storeWithUserId(DataBarangCreateRequest $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return abort(404, 'User not found');
        }

        $payload = $request->all();
        unset($payload['foto']);
        $foto = FileHandler::store(
            file: $request->file('foto'),
            targetDir: "uploads/{$user_id}/barang"
        );

        $payload['created_by_user_id'] = $user_id;
        $payload['thumbnail'] = $foto;

        $data_barang = DataBarangRepository::create($payload);
        return JsonResponseHandler::setResult($data_barang)->send();
    }

    public function view()
    {
        return view('DataBarang::view');
    }

    public function store(DataBarangCreateRequest $request)
    {
        $payload = $request->all();
        unset($payload['foto']);
        $foto = FileHandler::store(file: $request->file('foto'), targetDir: "uploads/" . Auth::user()->id . "/barang");
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

    public function getEdit($data, $id)
    {
        $data = DataBarang::where("id_barang", $id)->first();
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
        if ($request->has('foto')) {
            unset($payload['foto']);
            $foto = FileHandler::store(file: $request->file('foto'), targetDir: "uploads/" . Auth::user()->id . "/barang");
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

    //     public function exportPdf(Request $request)
    // {
    //     ini_set('memory_limit', '2048M');
    //     set_time_limit(0);

    //     $role = Auth::user()->role_ids[0];
    //     $limit = $request->input('limit', 5000);

    //     $query = DataBarang::with(['user' => function($q) {
    //         $q->select('user_id', 'nama'); // Sesuaikan dengan kolom di tabel toko_user
    //     }])
    //     ->select('id',
    //     'harga_umum',
    //     // 'kategori_umum',
    //     'produsen',
    //     'berat', 
    //     'nama_barang',
    //     'stock_global', 
    //     'created_by_user_id');

    //     // Pastikan data user terbaca:
    //     $data_barang = $query->get()->map(function ($item) {
    //         return [
    //             'id' => $item->id,
    //             'nama_barang' => $item->nama_barang,
    //             'produsen' => $item->produsen,
    //             // 'kategori_umum' => $item->kategori_umum,
    //             'harga_umum' => $item->harga_umum,
    //             'berat' => $item->berat,
    //             'stock_global' => $item->stock_global,
    //             'user_name' => $item->user ? $item->user->nama : 'Tidak Diketahui', // Pastikan ini
    //             'created_at' => $item->created_at?->format('Y-m-d H:i:s')
    //         ];
    //     });

    //     $data = [
    //         'data_barang' => $data_barang,
    //         'total_stok' => $data_barang->sum('stock_global'),
    //         'report_date' => now()->format('Y-m-d H:i:s')
    //     ];

    //     try {
    //         $pdf = Pdf::loadView('pdf.laporan_data_barang', $data)
    //             ->setPaper('A4', 'landscape')
    //             ->setOption('isHtml5ParserEnabled', true)
    //             ->setOption('isPhpEnabled', true)
    //             ->setOption('dpi', 96)
    //             ->setOption('isRemoteEnabled', false)
    //             ->setOption('defaultFont', 'Arial');
    //         return $pdf->download('laporan_data_barang_'.date('Y-m-d_H-i-s').'.pdf');
    //     } catch (Exception $e) {
    //         Log::error('PDF generation failed: ' . $e->getMessage());
    //         return response()->json([
    //             'error' => 'Failed to generate PDF',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function exportPdf(Request $request)
    {
        // Enable error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        // Set resource limits
        ini_set('memory_limit', '8192M');
        set_time_limit(0);
    
        try {
            $role = Auth::user()->role_ids[0];
            
            $query = DataBarang::with(['user' => function($q) {
                $q->select('user_id', 'nama');
            }])->select(
                'id', 'harga_umum', 'kategori_umum', 'produsen', 'berat', 
                'nama_barang', 'stock_global', 'created_by_user_id'
            );
    
            // Apply filters
            if ($request->filled('produsen')) {
                $query->where('produsen', $request->produsen);
            }
    
            if ($request->filled('user_id')) {
                $query->where('created_by_user_id', $request->user_id);
                $selectedUmkm = TokoUser::where('user_id', $request->user_id)->first();
                $umkmName = $selectedUmkm ? $selectedUmkm->nama : 'UMKM Tidak Diketahui';
            } else {
                $umkmName = 'Semua UMKM';
            }
    
            if ($request->filled('kategori_umum')) {
                $query->where('kategori_umum', $request->kategori_umum);
            }
    
            // For non-admin roles
            if ($role != 1 && $role != 5) {
                $query->where('created_by_user_id', Auth::id());
                $umkmName = Auth::user()->name; // Atau ambil dari relasi toko user
            }
    
            // Get data with chunking
            $data_barang = collect();
            $query->chunk(200, function ($items) use (&$data_barang) {
                foreach ($items as $item) {
                    $data_barang->push([
                        'id' => $item->id,
                        'nama_barang' => $item->nama_barang,
                        'produsen' => $item->produsen,
                        'kategori_umum' => $item->kategori_umum,
                        'harga_umum' => $item->harga_umum,
                        'berat' => $item->berat,
                        'stock_global' => $item->stock_global,
                        'user_name' => $item->user ? $item->user->nama : 'Tidak Diketahui',
                        'created_at' => $item->created_at?->format('Y-m-d H:i:s')
                    ]);
                }
            });
    
            if ($data_barang->isEmpty()) {
                return response()->json([
                    'error' => 'Tidak ada data yang ditemukan dengan filter yang dipilih'
                ], 404);
            }
    
            $data = [
                'data_barang' => $data_barang,
                'total_stok' => $data_barang->sum('stock_global'),
                'report_date' => now()->format('Y-m-d H:i:s'),
                'filter_produsen' => $request->produsen ?? 'Semua Produsen',
                'filter_umkm' => $umkmName, // Menggunakan variabel yang sudah ditentukan
                'filter_kategori' => $request->kategori_umum ?? 'Semua Kategori'
            ];
    
            $pdf = Pdf::loadView('pdf.laporan_data_barang', $data)
                ->setPaper('A4', 'landscape');
                
            return $pdf->download('laporan_data_barang_'.date('Y-m-d_H-i-s').'.pdf');
    
        } catch (Exception $e) {
            Log::error('PDF generation error: '.$e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'error' => 'Terjadi kesalahan saat generate PDF',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
