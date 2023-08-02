<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Companies\CreateCompanyAction;
use App\Actions\Companies\DestroyCompanyAction;
use App\Actions\Companies\UpdateCompanyAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Support\PaginationBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(): PaginationBuilder
    {
        return PaginationBuilder::for(Company::class)
            ->resource(CompanyResource::class);
    }

    public function store(CompanyRequest $request)
    {
        $data = $request->validated();
        $company = (new CreateCompanyAction())->execute($data);
        return CompanyResource::make($company);
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $data = $request->validated();
        $company = (new UpdateCompanyAction())->execute($company, $data);
        return CompanyResource::make($company);
    }

    public function show(Company $company): JsonResponse
    {
        $company->load('owner');
        return response()->json(CompanyResource::make($company), 200);
    }

    public function destroy(Company $company): JsonResponse
    {
        (new DestroyCompanyAction())->execute($company);
        return response()->json(['message' => 'Entity deleted'], 200);
    }
}
