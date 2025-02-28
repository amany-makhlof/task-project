<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\LoginService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = LoginService::authenticate($request->validated());

        return (new UserResource($user))
            ->additional(['token' => $user->getToken()])
            ->response()
            ->setStatusCode(200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'data' => 'successLogout',
        ]);
    }
}
