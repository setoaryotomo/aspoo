<?php

namespace App\Modules\permintaanparcel\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\ParcelChildren;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\permintaanparcel\Models\permintaanparcel;
use App\Modules\permintaanparcel\Repositories\permintaanparcelRepository;
use App\Modules\permintaanparcel\Requests\permintaanparcelCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class permintaanparcelController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('permintaanparcel::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = permintaanparcelRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('permintaanparcel::create');
    }

    // public function store(permintaanparcelCreateRequest $request)
    // {
    //     $payload = $request->all();
    //     $permintaan_parcel = permintaanparcelRepository::create($payload);
    //     return JsonResponseHandler::setResult($permintaan_parcel)->send();
    // }

    public function store(permintaanparcelCreateRequest $request)
{
    $payload = $request->all();
    
    // Tambahkan user_id yang valid
    $payload['user_id'] = auth()->user()->id; // atau sumber lain untuk user_id
    
    $permintaan_parcel = permintaanparcelRepository::create($payload);
    return JsonResponseHandler::setResult($permintaan_parcel)->send();
}


    public function show(Request $request, $id)
    {
        $permintaan_parcel = permintaanparcelRepository::get($id);
        return JsonResponseHandler::setResult($permintaan_parcel)->send();
    }

    public function edit($id)
    {
        return view('permintaanparcel::edit', ['permintaan_parcel_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $permintaan_parcel = permintaanparcelRepository::update($id, $payload);
        return JsonResponseHandler::setResult($permintaan_parcel)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = permintaanparcelRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }

    public function preview(Request $request, $id){
        $data = permintaanparcel::where('id',$id)->with(['user'])->first();
        $barang = DataBarang::select('*')->with(['user'])->get();

        $selectedItems = ParcelChildren::where('parcel_id', $id)->with(['parcel','barang'])->get();
        // dd($selectedItems);
        
        $card = [
            'barang' => $barang,
            'selectedItems' => $selectedItems
        ];
        // dd($card);
        return view('permintaanparcel::preview',compact('data', 'card'));
    }
    
    // public function saveSelectedItems(Request $request, $id)
    // {
    //     try {
    //         $items = $request->input('items');
    //         $total = $request->input('total');
    
    //         foreach ($items as $item) {
    //             ParcelChildren::create([
    //                 'parcel_id' => $id, 
    //                 'barang_id' => $item['id'],
    //                 'total_harga' => $item['price'],
    //             ]);
    //         }
    
    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function saveSelectedItems(Request $request, $id)
{
    try {
        $items = $request->input('items');
        $total = $request->input('total');

        // Menghapus semua barang yang terkait dengan parcel ini
        ParcelChildren::where('parcel_id', $id)->delete();

        // Menyimpan barang baru
        foreach ($items as $item) {
            ParcelChildren::create([
                'parcel_id' => $id,
                'barang_id' => $item['id'],
                'total_harga' => $item['price'],
            ]);
        }

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
}
