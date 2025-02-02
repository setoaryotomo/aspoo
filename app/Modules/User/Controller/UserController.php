<?php

namespace App\Modules\User\Controller;

use App\Handler\JsonResponseHandler;
use App\Type\JsonResponseType;
use App\Http\Controllers\Controller;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\User\Model\UserModel;
use App\Modules\User\Model\UserRoleModel;
use App\Modules\User\Request\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function loginPage(Request $request)
    {
        return view('User::login');
    }
    public function me()
    {
        $user = UserModel::where('id', Auth::user()->id)->first();
        return JsonResponseHandler::setResult($user)->send();
    }
    public function login(UserLoginRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me');

        $user = UserModel::where('username', $username)->orWhere('email', $username)->first();
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
        Auth::login($user, $remember_me);
        return JsonResponseHandler::setCode(JsonResponseType::SUCCESS)
            ->setMessage("Berhasil Login")
            ->setResult($user)
            ->send();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return JsonResponseHandler::setMessage("Logout Berhasil")->send();
    }

    public function logoutWeb(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to("/p/login");
    }
    
    public function index()
    {
        return view('User::index');
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $keyword = $request->input('keyword') != null ? $request->input('keyword') : null;
        $Users = UserModel::search($keyword)->paginate($per_page);
        return JsonResponseHandler::setResult($Users)->send();
    }

    public function detail(Request $request, $user_id)
    {
        $User = UserModel::where('id', $user_id)->first();
        return JsonResponseHandler::setResult($User)->send();
    }

    public function create()
    {
        return view('User::create');
    }

    public function store(Request $request)
    {
        $payload = $request->all();
        $payload['password'] = Hash::make($payload['password']);
        $User = UserModel::create($payload);
        return JsonResponseHandler::setResult($User)->send();
    }

    public function edit(Request $request, $user_id)
    {
        return view('User::edit', ['user_id' => $user_id]);
    }

    public function update(Request $request, $user_id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        if ($payload['password'] != null && $payload['password'] != "") {
            $payload['password'] = Hash::make($payload['password']);
        } else {
            unset($payload['password']);
        }
        $User = UserModel::where('id', $user_id)->update($payload);
        return JsonResponseHandler::setResult($User)->send();
    }

    public function getRoles(Request $request, $user_id)
    {
        $user = UserModel::where('id', $user_id)->first();
        return JsonResponseHandler::setResult($user->roles)->send();
    }

    public function addRole(Request $request, $user_id)
    {
        $role_id = $request->input('role_id');
        $upsert = UserRoleModel::firstOrCreate(['user_id' => $user_id, 'role_id' => $role_id], ['user_id' => $user_id, 'role_id' => $role_id]);
        return JsonResponseHandler::setResult($upsert)->send();
    }

    public function removeRole(Request $request, $user_id, $role_id)
    {
        $delete = UserRoleModel::where('user_id', $user_id)->where('role_id', $role_id)->delete();
        return JsonResponseHandler::setResult($delete)->send();
    }
}
