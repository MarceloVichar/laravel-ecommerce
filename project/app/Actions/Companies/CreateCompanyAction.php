<?php

namespace App\Actions\Companies;

use App\Domains\Auth\Models\User;
use App\Enums\UserRolesEnum;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateCompanyAction
{
    public function execute($data): Company
    {
        try {
            DB::beginTransaction();

            $data['owner_password'] = Hash::make($data['owner_password']);
            $owner = new User([
                'name' => $data['owner_name'],
                'email' => $data['owner_email'],
                'password' => $data['owner_password'],
                'role' => UserRolesEnum::COMPANY_ADMIN
            ]);
            $owner->save();

            $company = new Company([
                'name' => $data['name'],
                'cnpj' => $data['cnpj'],
                'phone' => $data['phone'],
                'owner_id' => $owner->getAttribute('id'),
            ]);
            $company->save();

            DB::commit();

            return $company;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Failed to create the company', 500);
        }
    }
}
