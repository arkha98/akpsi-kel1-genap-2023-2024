<?php
namespace App\EnumHelpers;

class EnumMenus
{
    const _DASHBOARD = 'dashboard';
    const _PROFILE = 'profile';
    const _CHANGE_PASSWORD = 'change_password';
    const _USER_MANAGEMENT = 'user';
    const _TRAINING_PLAN = 'training_plans';

    const _DASHBOARD_ID = '7be1490a-8546-4080-8753-65bbc299a415';
    const _PROFILE_ID = 'bd7b95a8-344f-4d17-985c-41a2c10aa744';
    const _CHANGE_PASSWORD_ID = 'c1e8d96e-4101-4727-ac1b-e1f4cc25fdf0';
    const _USER_MANAGEMENT_ID = '59384da0-349b-4c32-a1da-0457898ea431';
    const _TRAINING_PLAN_ID = '9dcc4c3c-fb59-474e-8c94-8fbed9e24740';

    const _DASHBOARD_SLUG = 'dashboard';
    const _PROFILE_SLUG = 'profile';
    const _CHANGE_PASSWORD_SLUG = 'change-password';
    const _USER_MANAGEMENT_SLUG = 'user-management';
    const _TRAINING_PLAN_SLUG = 'training-plan';

    public static function getIdByCode($role) {
        if(self::_DASHBOARD == $role) return self::_DASHBOARD_ID;
        if(self::_PROFILE == $role) return self::_PROFILE_ID;
        if(self::_CHANGE_PASSWORD == $role) return self::_CHANGE_PASSWORD_ID;
        
        if(self::_USER_MANAGEMENT == $role) return self::_USER_MANAGEMENT_ID;
        if(self::_TRAINING_PLAN == $role) return self::_TRAINING_PLAN_ID;
        
        return '';
    }

    public static function getSlugByCode($role) {
        if(self::_DASHBOARD == $role) return self::_DASHBOARD_SLUG;
        if(self::_PROFILE == $role) return self::_PROFILE_SLUG;
        if(self::_CHANGE_PASSWORD == $role) return self::_CHANGE_PASSWORD_SLUG;

        if(self::_USER_MANAGEMENT == $role) return self::_USER_MANAGEMENT_SLUG;
        if(self::_TRAINING_PLAN == $role) return self::_TRAINING_PLAN_SLUG;

        return '';
    }

    public static function getAllCode() {
        $result = [
            self::_DASHBOARD,
            self::_PROFILE,
            self::_CHANGE_PASSWORD,

            self::_USER_MANAGEMENT,
            self::_TRAINING_PLAN,
        ];        

        return $result;
    }

    public static function getAllCodeForSuperAdmin() {
        $result = [
            self::_DASHBOARD,
            self::_PROFILE,
            self::_CHANGE_PASSWORD,

            self::_USER_MANAGEMENT,
            self::_TRAINING_PLAN,
        ];        

        return $result;
    }

    public static function getAllCodeForSupportUnit() {
        $result = [
            self::_DASHBOARD,
            self::_PROFILE,
            self::_CHANGE_PASSWORD,

            self::_USER_MANAGEMENT,
            self::_TRAINING_PLAN
        ];        

        return $result;
    }

}