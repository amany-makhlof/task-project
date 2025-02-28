<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function show()
    {
        $user = User::findOrFail(Auth::id());

        return (new UserResource($user))
            ->additional(['token' => $user->getToken()])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateUserRequest  $request)
    {
        $user = User::findOrFail(Auth::id());

        $user->update([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'User data updated successfully']);
    }
}
