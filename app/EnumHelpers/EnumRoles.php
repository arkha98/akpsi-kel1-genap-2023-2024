<?php
namespace App\EnumHelpers;

class EnumRoles
{
    const _SUPERADMIN = 'superadmin';
    const _SUPPORT_UNIT = 'support_unit';

    const _SUPERADMIN_ID = '74ba087f-4f82-4473-abb9-0fcd58904415';
    const _SUPPORT_UNIT_ID = '8fca23eb-1d74-417b-a40c-e6ff5b474654';

    public static function getIdByCode($role) {
        if(self::_SUPERADMIN == $role) return self::_SUPERADMIN_ID;
        if(self::_SUPPORT_UNIT == $role) return self::_SUPPORT_UNIT_ID;
        return '';
    }

}