<?php

namespace App\Actions\Companies;

use App\Models\Company;

class UpdateCompanyAction
{
    public function execute(Company $company, $data): Company
    {
        $company->update($data);
        return $company;
    }
}
