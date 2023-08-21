<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Auth\UserAuthGuard;

class AuthController extends Controller
{
    protected $userProvider;

    public function __construct(UserAuthGuard $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function login(Request $request)
    {
        // Retrieve user by credentials
        $credentials = $request->only('email', 'password');
        $user = $this->userProvider->retrieveByCredentials($credentials);

        if ($user && $this->userProvider->validateCredentials($user, $credentials)) {
            // The user's credentials are valid

            
            
            $token = $user->createToken('main')->plainTextToken;

            Auth::login($user);

            $roleName = $this->getRole($user->role_id);

            unset($user['role_id']);
            $user['role'] = $roleName;

            return response([
                'user' => $user,
                'token' => $token
            ]);

        } else {
            return response([
                'error' => 'Invalid email or password combination.'
            ], 422);
        }
    }

    public function logout(Request $request)
    {

        Auth::logout();
        
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
