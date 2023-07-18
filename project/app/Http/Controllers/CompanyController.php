<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateCompanyAction;
use App\Actions\Companies\UpdateCompanyAction;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Support\PaginationBuilder;
use Illuminate\Http\JsonResponse;

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
        $company->deleteOrFail();
        return response()->json(['message'=>'deleted entity'], 200);
    }
}
