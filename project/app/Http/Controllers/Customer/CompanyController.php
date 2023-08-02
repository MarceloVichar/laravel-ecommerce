<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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

    public function show(Company $company): JsonResponse
    {
        $company->load('owner');
        return response()->json(CompanyResource::make($company), 200);
    }
}
