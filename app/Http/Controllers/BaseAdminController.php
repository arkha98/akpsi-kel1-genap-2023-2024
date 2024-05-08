<?php

namespace App\Http\Controllers;

use App\Models\HistLoginLog;
use App\Models\RoleMenuMapping;
use App\Models\RoleUserMapping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BaseAdminController extends Controller
{
    public function __construct()
    {
    }

    public function checkAuth()
    {
        try {
            $isLogin = false;
            if (Auth::check()) 
                $isLogin = true;               

            return $isLogin;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function menuPrivilageUser()
    {
        $roleMenuMapping = null;
        try {
            $roleUserList = RoleUserMapping::where('user_id', Auth::user()->id)->where('is_active', true)->get();
            if(!$roleUserList){
                return $roleMenuMapping;
            }
            $ids = [];
            foreach ($roleUserList as $item) {
                $ids[] = $item['role_id'];
            }
            
            $roleMenuMapping = RoleMenuMapping::whereIn('role_id', $ids)->where('is_active', true)->get();
            dd(Auth::user()->id);
            $roleMenuMapping = $roleMenuMapping->map(function ($array) {
                return collect($array)->unique('id')->all();
            });

            return $roleMenuMapping;
        } catch (\Throwable $th) {
            return $roleMenuMapping;
        }
    }

    public function getSingleMenuPrivilage($menu_id)
    {
        $roleMenuMapping = null;
        try {
            $roleUserList = RoleUserMapping::where('user_id', Auth::user()->id)->where('is_active', true)->get();
            if(!$roleUserList){
                return $roleMenuMapping;
            }

            $roleMenuMapping = RoleMenuMapping::
                                    whereIn('role_id', $roleUserList->pluck('role_id'))
                                    ->where('menu_id', $menu_id)
                                    ->where('IS_ACTIVE', true)
                                    ->get();
            $roleMenuMapping = $roleMenuMapping->map(function ($array) {
                return collect($array)->unique('id')->all();
            });

            return $roleMenuMapping;
        } catch (\Throwable $th) {
            return $roleMenuMapping;
        }
    }

    public function checkMenuPrivilage($menuId, $ColumnflagToCheck = '')
    {
        $roleMenuMapping = null;
        try {
            $roleUserList = RoleUserMapping::where('user_id', Auth::user()->id)->where('is_active', true)->get();
            if(!$roleUserList){
                return false;
            }

            $roleMenuMapping = RoleMenuMapping::whereIn('role_id', $roleUserList->pluck('role_id'))->where('menu_id', $menuId)->where('IS_ACTIVE', true)->first();

            if (!$roleMenuMapping) {
                return false;
            }

            if ($roleMenuMapping['IS_ACTIVE'] != 1) {
                return false;
            }

            if($ColumnflagToCheck){
                if ($roleMenuMapping[$ColumnflagToCheck] != 1) {
                    return false;
                }
            }            

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function clearLogout()
    {
        if(Auth::check()){
            try {
                $sesi = HistLoginLog::where('id', session('sesi_login_id'))->first();
                $sesi->logout_date_php = now();
                $sesi->logout_time_php = time();

                $sesi['updated_by'] = Auth::id();
                $sesi->save();

                $user = User::where('id', Auth::id())->first();
                $user['last_logout_date'] = $sesi['logout_date_php'];
                $user['updated_by'] = Auth::id();
                $user->save();

            } catch (\Throwable $th) {
                Log::error("Logout: " . $th->getMessage());
            }

            Session::flush();
            Auth::logout();
        }

        if (request()->session()) {
            request()->session()->flush();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
    }

    public function getLatestSesiLogin()
    {
        $sesiLogin = HistLoginLog::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

        return $sesiLogin;
    }
    
}
