<?php

namespace App\Actions\Companies;

use App\Enums\UserRolesEnum;
use App\Models\Company;
use Exception;

class GetUserCompanyAction
{
    /**
     * @throws Exception
     */
    public function execute(): Company
    {
        if (!current_user()->company_id || current_user()->role !== UserRolesEnum::COMPANY_ADMIN) {
            throw new Exception('User not has a company', '404');
        }

        $userCompany = current_user()->company()->get()->first();

        if (!$userCompany) {
            throw new Exception('User not has a company', '404');
        }

        return $userCompany;
    }
}
