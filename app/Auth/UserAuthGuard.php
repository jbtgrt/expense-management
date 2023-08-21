<?php
namespace App\Auth;

use App\Models\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

use Hash, Session;

class UserAuthGuard implements UserProvider {

    public function retrieveById($identifier)
    {
        $user = User::find($identifier);

        if($user)
        {
            return $user;
        }
        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        $user = User::where('id','=',$identifier)->where('remember_token','=',$token)->first();

        if($user)
        {
            return $user;
        }
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }

    public function retrieveByCredentials(array $credentials)
    {
        $user = User::where('email','=',$credentials['email'])->first();

        if($user)
        {
            return $user;
        }
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if( Hash::check( $credentials['password'], $user->getAuthPassword() ) && $user->email == $credentials['email'] )
        {
            $user->last_login = Date('Y-m-d H:i:s');
            $user->save();

            $result = User::where('email',$credentials['email'])->first();
            Session::put('stat', 'user');
            Session::put('user_session', $result);

            return true;
        }
        return false;
    }
   
}