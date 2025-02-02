<?php

namespace App\Modules\PortalUser\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\PortalUser\Repositories\PortalUserRepository;
use App\Modules\PortalUser\Requests\PortalUserCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\Portal\Model\UserDetail;
use App\Modules\Portal\Model\UserPortal;
use App\Modules\PortalUser\Models\TokoUser;
use App\Modules\User\Controller\UserController;
use App\Modules\User\Model\UserModel;
use App\Type\JsonResponseType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PortalUserController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('PortalUser::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = PortalUserRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('PortalUser::create');
    }

    public function store(PortalUserCreateRequest $request)
    {
        $payload = $request->all();
        
        if (!empty($payload['kota_id'])) {
            $get_rajaongkircity = $payload['kota_id'];
            $rajaongkir_city = Kota::find($get_rajaongkircity);
    
            if ($rajaongkir_city) {
                $kota_rajaongkir = $rajaongkir_city->rajaongkir_city;
                $postal_rajaongkir = $rajaongkir_city->rajaongkir_postal;
            } else {
                $kota_rajaongkir = null;
                $postal_rajaongkir = null;
            }
        } else {
            $kota_rajaongkir = null;
            $postal_rajaongkir = null;
        }
    
        $role = $payload['role_id'];
        $formDataUser = new Request([
            'name' => $payload['nama'],
            'email' => $payload['email'],
            'username' => $payload['email'],
            'password' => $payload['password'],
        ]);
        $payload['password'] = Hash::make($request->password);
    
        $userController = new UserController();
        try {
            DB::beginTransaction();
            $dataUser = $userController->store($formDataUser)->original['result'];
            $payload['user_id'] = $dataUser['id'];
            $portaluser = PortalUserRepository::create($payload);
            $roleRequest = new Request(['role_id' => $role]);
            $userController->addRole($roleRequest, $dataUser->id);
    
            // Create user details based on role
            if ($role == "3" || $role == "4") {
                TokoUser::create([
                    'user_id' => $dataUser['id'],
                    'nama' => $payload['nama'],
                ]);
                UserDetail::create([
                    'user_id' => $dataUser->id,
                    'alamat' => $payload['alamat'],
                    'tanggal_lahir' => $payload['tanggal_lahir'],
                    'provinsi' => $payload['provinsi_id'],
                    'kota' => $payload['kota_id'] ?? null,
                    'kota_rajaongkir' => $kota_rajaongkir,
                    'postal_rajaongkir' => $postal_rajaongkir,
                    'kecamatan' => $payload['kecamatan_id'] ?? null,
                    'kelurahan' => $payload['kelurahan_id'] ?? null,
                ]);
            } else {
                UserDetail::create([
                    'user_id' => $dataUser->id,
                    'alamat' => $payload['alamat'],
                    'tanggal_lahir' => $payload['tanggal_lahir'],
                ]);
            }
    
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponseHandler::setResult($e)->send();
        }
    
        return JsonResponseHandler::setResult($portaluser)->send();
    }
    
    
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me');
        
        $user = UserModel::where('email', $email)->orWhere('email', $email)->first();
        if ($user == null) {
            return JsonResponseHandler::setCode(JsonResponseType::ERROR)
                ->setStatus(400)
                ->setMessage("User tidak ditemukan")
                ->send();
        }
        $password_valid = Hash::check($password, $user->password);
        if (!$password_valid) {
            return JsonResponseHandler::setCode(JsonResponseType::ERROR)
                ->setStatus(400)
                ->setMessage("Password Salah")
                ->send();
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication was successful
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
    
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }
        return JsonResponseHandler::setCode(JsonResponseType::SUCCESS)
            ->setMessage("Berhasil Login")
            ->setResult($user)
            ->send();
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return JsonResponseHandler::setCode(JsonResponseType::SUCCESS)
        ->setMessage("Berhasil Logout")
        ->send();
    }
    public function show(Request $request, $id)
    {
        $portaluser = PortalUserRepository::get($id);
        return JsonResponseHandler::setResult($portaluser)->send();
    }

    public function edit($id)
    {
        return view('PortalUser::edit', ['portaluser_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $portaluser = PortalUserRepository::update($id, $payload);
        return JsonResponseHandler::setResult($portaluser)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = PortalUserRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
