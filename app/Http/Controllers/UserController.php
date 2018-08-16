<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('company')->get();

        return response()->json($users);
    }

    public function store(StoreUser $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        $user->company;

        return response()->json($user, 201);
    }

    public function update(StoreUser $request, $id)
    {
        $validatedData = $request->validated();

        $user = User::find($id);
        $user->fill($validatedData);
        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User was deleted'
        ]);
    }
}
