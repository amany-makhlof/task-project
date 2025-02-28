<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\RegisterService;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = RegisterService::register($request->validated());
        event(new UserRegistered($user));

        return (new UserResource($user))
            ->additional(['token' => $user->getToken()])
            ->response()
            ->setStatusCode(200);
    }
}
