<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->allUsers();

        return response([
            'data' => UserResource::collection($users)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'role_id' => 'required|int'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'image' => 'images/avatars/user-image.jpg',
            'email' => $data['email'],
            'password' => bcrypt('User123#'),
            'role_id' => $data['role_id']
        ]);

        $users = $this->allUsers();

        return response([
            'data' => UserResource::collection($users)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        // return new UserResource($request->$id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$id,
            'role_id' => 'required|int'
        ]);

        $resource = User::findOrFail($id);

        $resource->update($validatedData);

        $users = $this->allUsers();

        return response([
            'data' => UserResource::collection($users)
        ]);
    }

    public function updateInfo(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $user = User::findOrFail($id);

        // Verify the current password before updating
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['errors' => [ 'error' => ['Current password does not match.']]], 422);
        }  

        $user->update([
            'password' => Hash::make($validatedData['password'])
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
    public function destroy(User $user)
    {
        $user->delete(); 

        $users = $this->allUsers();

        return response([
            'data' => UserResource::collection($users)
        ]);
    }


    private function allUsers(){
        $users = User::query()
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->orderBy('users.created_at', 'ASC')
            ->get(['users.*', 'roles.display_name as role_display_name']);

        return $users;
    }
}
