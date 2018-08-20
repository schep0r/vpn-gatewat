<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(User::all());
    }

    public function store(StoreUser $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function update(StoreUser $request, $id)
    {
        $validatedData = $request->validated();

        $user = User::find($id);
        $user->fill($validatedData);
        $user->save();

        return new UserResource($user);
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
