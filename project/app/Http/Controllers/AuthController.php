<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateUserAction;
use App\Domains\Auth\Actions\LoginAction;
use App\Domains\Auth\Adapters\LoginAdapter;
use App\Domains\Auth\Adapters\RegisterAdapter;
use App\Enums\UserRolesEnum;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = (new LoginAdapter())->handle($request->validated());
        $user = (new LoginAction())->execute($data);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        if (!Hash::check($data->password, $user->password)) {
            return response()->json(['message' => 'wrong password'], 403);
        }
        $token = $user->createToken('API TOKEN')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registerData = (new RegisterAdapter())->handle($request->validated());
        $user = (new CreateUserAction())->execute($registerData->toArray(), UserRolesEnum::CUSTOMER);
        return response()->json([UserResource::make($user)], 201);
    }
}
