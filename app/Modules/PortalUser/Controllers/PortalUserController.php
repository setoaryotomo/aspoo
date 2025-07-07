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
        $per_page = $request->input('per_page') ?? 15;
        $data = PortalUserRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('PortalUser::create');
    }

    public function store(PortalUserCreateRequest $request)
    {
        $kota_id = $request->input('kota_id');
        $kota_rajaongkir = null;
        $postal_rajaongkir = null;

        if (!empty($kota_id)) {
            $rajaongkir_city = Kota::find($kota_id);
            if ($rajaongkir_city) {
                $kota_rajaongkir = $rajaongkir_city->rajaongkir_city;
                $postal_rajaongkir = $rajaongkir_city->rajaongkir_postal;
            }
        }

        $role_id = $request->input('role_id');
        $formDataUser = new Request([
            'name' => $request->input('nama'),
            'email' => $request->input('email'),
            'username' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $userController = new UserController();
        try {
            DB::beginTransaction();
            $dataUser = $userController->store($formDataUser)->original['result'];
            $user_id = $dataUser['id'];

            $portalUserData = [
                'user_id' => $user_id,
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $role_id,
                'alamat' => $request->input('alamat'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'telepon' => $request->input('telepon'),
                'provinsi_id' => $request->input('provinsi_id'),
                'kota_id' => $kota_id,
                'kecamatan_id' => $request->input('kecamatan_id'),
                'kelurahan_id' => $request->input('kelurahan_id'),
            ];
            $portaluser = PortalUserRepository::create($portalUserData);

            $roleRequest = new Request(['role_id' => $role_id]);
            $userController->addRole($roleRequest, $dataUser->id);

            // Create user details based on role
            if ($role_id == 3 || $role_id == 4) {
                TokoUser::create([
                    'user_id' => $user_id,
                    'nama' => $request->input('nama_toko'),
                    'ijin_usaha' => $request->input('ijin_usaha'),
                    'npwp' => $request->input('npwp'),
                    'omset' => $request->input('omset'),
                ]);
                UserDetail::create([
                    'user_id' => $user_id,
                    'alamat' => $request->input('alamat'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'telepon' => $request->input('telepon'),
                    'provinsi' => $request->input('provinsi_id'),
                    'kota' => $kota_id,
                    'kota_rajaongkir' => $kota_rajaongkir,
                    'postal_rajaongkir' => $postal_rajaongkir,
                    'kecamatan' => $request->input('kecamatan_id'),
                    'kelurahan' => $request->input('kelurahan_id'),
                ]);
            } else {
                UserDetail::create([
                    'user_id' => $user_id,
                    'alamat' => $request->input('alamat'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'telepon' => $request->input('telepon'),
                    'provinsi' => $request->input('provinsi_id'),
                    'kota' => $kota_id,
                    'kota_rajaongkir' => $kota_rajaongkir,
                    'postal_rajaongkir' => $postal_rajaongkir,
                    'kecamatan' => $request->input('kecamatan_id'),
                    'kelurahan' => $request->input('kelurahan_id'),
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponseHandler::setResult($e)->send();
        }

        return JsonResponseHandler::setResult($portaluser)->send();
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me');

        $user = UserModel::where('email', $email)->first();
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
        $data = $request->all();
        unset($data['created_at']);
        unset($data['updated_at']);
        $portaluser = PortalUserRepository::update($id, $data);
        return JsonResponseHandler::setResult($portaluser)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = PortalUserRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}