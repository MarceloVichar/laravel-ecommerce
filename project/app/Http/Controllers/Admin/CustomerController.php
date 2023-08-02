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

class CustomerController extends Controller
{
    public function index(): PaginationBuilder
    {
        return PaginationBuilder::for(User::class)
            ->criteria([
                new WhereCriteria('role', UserRolesEnum::CUSTOMER)
            ])
            ->resource(UserResource::class);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = (new CreateUserAction())->execute($data, UserRolesEnum::CUSTOMER);
        return response()->json( UserResource::make($user), ResponseAlias::HTTP_OK);
    }

    public function update(UserRequest $request, User $customer): JsonResponse
    {
        if ($customer->getAttribute('role') !== UserRolesEnum::CUSTOMER)
        {
            return response()->json(['message' => 'Not authorized'], ResponseAlias::HTTP_FORBIDDEN);
        }

        $data = $request->validated();
        $customer = (new UpdateUserAction())->execute($customer, $data);
        return response()->json(UserResource::make($customer), ResponseAlias::HTTP_OK);
    }

    public function show(User $customer): JsonResponse
    {
        if ($customer->getAttribute('role') !== UserRolesEnum::CUSTOMER)
        {
            return response()->json(['message' => 'Not authorized'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $customer->load('company');
        return response()->json(UserResource::make($customer), ResponseAlias::HTTP_OK);
    }

    public function destroy(User $customer): JsonResponse
    {
        if ($customer->getAttribute('role') !== UserRolesEnum::CUSTOMER)
        {
            return response()->json(['message' => 'Not authorized'], ResponseAlias::HTTP_FORBIDDEN);
        }
        $customer->deleteOrFail();
        return response()->json(['message'=>'deleted entity'], 200);
    }
}
