<?php
namespace App\Enums;

abstract class UserRolesEnum extends Enum
{
    const ADMIN = 'ADMIN';
    const CUSTOMER = 'CUSTOMER';
    const COMPANY_ADMIN = 'COMPANY_ADMIN';
}
