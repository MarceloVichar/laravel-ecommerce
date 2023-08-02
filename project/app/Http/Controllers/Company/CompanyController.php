<?php

namespace App\Http\Controllers\Company;

use App\Actions\Companies\DestroyCompanyAction;
use App\Actions\Companies\GetUserCompanyAction;
use App\Actions\Companies\UpdateCompanyAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function update(CompanyRequest $request): JsonResponse
    {
        $company = (new GetUserCompanyAction())->execute();
        $data = $request->validated();
        $company = (new UpdateCompanyAction())->execute($company, $data);
        return response()->json(CompanyResource::make($company), 200);
    }

    public function show(): JsonResponse
    {
        $company = (new GetUserCompanyAction())->execute();
        $company->load('owner');
        return response()->json(CompanyResource::make($company), 200);
    }

    public function destroy(): JsonResponse
    {
        $company = (new GetUserCompanyAction())->execute();
        (new DestroyCompanyAction())->execute($company);
        return response()->json(['message' => 'Entity deleted'], 200);
    }
}
