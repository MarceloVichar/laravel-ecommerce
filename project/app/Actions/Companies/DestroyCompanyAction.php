<?php

namespace App\Actions\Companies;

use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class DestroyCompanyAction
{
    /**
     * @throws Throwable
     */
    public function execute(Company $company)
    {
        try {
            DB::beginTransaction();

            $company->products()->delete();
            $company->owner()->delete();
            $company->deleteOrFail();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();

            throw new Exception('Destroy company failed', '404');
        }
    }
}
