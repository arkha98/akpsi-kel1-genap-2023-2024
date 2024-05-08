<?php

namespace App\Helpers;

use App\EnumHelpers\EnumRoles;
use App\Models\RoleMenu;
use App\Models\UserRole;
use App\Repos\UserRepository;
use App\Repos\UserRoleMappingRepository;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserHelper
{
    public static function checkRestrictReadUser($menuId, $userId) {

        $role = UserRole::where('user_id', $userId)->first();
        if(!$role) return true;

        $menu = RoleMenu::where('menu_id', $menuId)->where('role_id', $role->id)->first();
        if(!$menu) return true;

        if($menu->IS_READ_RESTRICT_USER != 1) return false;
        return true;
        
    }

    public static function checkRestrictUpdateUser($menuId, $userId) {

        $role = UserRole::where('user_id', $userId)->first();
        if(!$role) return true;

        $menu = RoleMenu::where('menu_id', $menuId)->where('role_id', $role->id)->first();
        if(!$menu) return true;

        if($menu->IS_UPDATE_RESTRICT_USER != 1) return false;
        return true;
        
    }

    public static function isPeserta($userId) {

        $role = UserRole::where('user_id', $userId)->first();
        if(!$role) return false;
        if($role->role_id == EnumRoles::_PESERTA_ID) return true;
        return false;
    }

    public static function isSuperAdmin($userId) {

        $role = UserRole::where('user_id', $userId)->first();
        if(!$role) return false;
        if($role->role_id == EnumRoles::_SUPERADMIN_ID) return true;
        return false;
    }
}