<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateCompanyAction;
use App\Actions\Companies\UpdateCompanyAction;
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
        try {
            DB::beginTransaction();

            $company->owner()->delete();
            $company->deleteOrFail();

            DB::commit();

            return response()->json(['message' => 'Company and owner user successfully deleted.'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to delete company and owner user.'], 500);
        }
    }
}
