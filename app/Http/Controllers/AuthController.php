<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);


        $user = User::create([
            'name' => $data['name'],
            'image' => 'images/avatars/'.$request->role.'-image.jpg',
            'role_id' => 1,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;

        $roleName = $this->getRole($user->role_id);
        
        unset($user['role_id']);
        $user['role'] = $roleName;

        return response([
            'user' => $user,
            'token' => $token
        ]);


    }

    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email|string',
            'password' => [
                'required',
            ],
            'remember' => 'boolean',
            'role_id' => 'required|int'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if(!Auth::attempt($credentials, $remember)){
            return response([
                'errors' => [ 'invalid' => ['Invalid credentials.']]
            ], 422);
        }

        $user = Auth::user();

        Session::put('credentials', $user);

        $token = $user->createToken('main')->plainTextToken;

        $roleName = $this->getRole($user->role_id);

        unset($user['role_id']);
        $user['role'] = $roleName;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request){

        Auth::logout();
        // Auth::logout();

        return response([
            'message' => 'Logged out successfully!'
        ], 200);
    }


    private function getRole($role_id)
    {
        $role = Role::find($role_id);

        if (!$role) {
            $roleName = 'Unknown Role';
        } else {
            $roleName = $role->display_name;
        }

        return $roleName;
    }


}
    