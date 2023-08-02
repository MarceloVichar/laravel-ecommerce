<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(UserResource::make(current_user()));
    }

    public function update(ProfileRequest $request): JsonResponse
    {
        current_user()->update($request->validated());
        return response()->json(UserResource::make(current_user()));
    }
}
