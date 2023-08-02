<?php

namespace App\Http\Middleware;

use App\Enums\UserRolesEnum;
use Closure;
use Illuminate\Http\Request;

class CompanyUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!current_user() || current_user()->role !== UserRolesEnum::COMPANY_ADMIN) {
           return response()->json(['message' => 'Access denied.'], 403);
        }

        return $next($request);
    }
}
