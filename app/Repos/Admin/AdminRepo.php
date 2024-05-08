<?php

namespace App\Repos\Admin;

use App\Models\MenuAksesMapping;
use App\Models\RoleMenuMapping;
use Illuminate\Support\Collection;

class AdminRepo{

    
    public function __construct()
    {
        
    }

    public function getAllMenuByRoleId($roleId) {
        $menus = RoleMenuMapping::where('role_id', $roleId)->get();
        return $menus;
        
    }

}
