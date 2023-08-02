<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Users\CreateUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Criterias\Common\WhereCriteria;
use App\Domains\Auth\Models\User;
use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Support\PaginationBuilder;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdminController extends Controller
{
    public function index(): PaginationBuilder
    {
        return PaginationBuilder::for(User::class)
            ->criteria([
                new WhereCriteria('role', UserRolesEnum::ADMIN)
            ])
            ->resource(UserResource::class);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = (new CreateUserAction())->execute($data, UserRolesEnum::ADMIN);
        return response()->json( UserResource::make($user), ResponseAlias::HTTP_OK);
    }

    public function update(UserRequest $request, User $admin): JsonResponse
    {
        if ($admin->getAttribute('role') !== UserRolesEnum::ADMIN)
        {
            return response()->json(['message' => 'Not authorized'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $data = $request->validated();
        $admin = (new UpdateUserAction())->execute($admin, $data);
        return response()->json(UserResource::make($admin), ResponseAlias::HTTP_OK);
    }

    public function show(User $admin): JsonResponse
    {
        if ($admin->getAttribute('role') !== UserRolesEnum::ADMIN)
        {
            return response()->json(['message' => 'Not authorized'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $admin->load('company');
        return response()->json(UserResource::make($admin), ResponseAlias::HTTP_OK);
    }

    public function destroy(User $admin): JsonResponse
    {
        if ($admin->getAttribute('role') !== UserRolesEnum::ADMIN)
        {
            return response()->json(['message' => 'Not authorized'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $admin->deleteOrFail();
        return response()->json(['message'=>'deleted entity'], 200);
    }
}
