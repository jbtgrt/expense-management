<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleTypeResource;
use Illuminate\Http\Request;
use App\Models\Role;
use Nette\Utils\DateTime;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'display_name' => 'required|string|unique:roles,display_name',
            'description' => 'required|string'
        ]);

        $role = Role::create([
            'display_name' => $data['display_name'],
            'description' => $data['description']
        ]);

        return response([
            'data' => RoleResource::collection(Role::all())
        ]);
    }

    public function roleTypes()
    {
        return RoleTypeResource::collection(Role::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role, Request $request)
    {
        // return new RoleResource($request->$id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'display_name' => 'required|string|unique:roles,display_name,'.$id,
            'description' => 'required|string'
        ]);

        $resource = Role::findOrFail($id);

        $resource->update($validatedData);

        return response([
            'data' => RoleResource::collection(Role::all())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
    public function destroy(Role $role)
    {
        $role->delete(); 

        return RoleResource::collection(Role::all());
    }
}
