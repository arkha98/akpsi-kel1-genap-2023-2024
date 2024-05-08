<?php

namespace App\Http\Controllers\Admin;

use App\EnumHelpers\EnumMenus;
use App\EnumHelpers\EnumViewPageAdmin;
use App\Enums\EnumMenu;
use App\Enums\EnumViewPage;
use App\Helpers\CustomHelper;
use App\Http\Controllers\BaseAdminController;
use App\Repos\Admin\AdminRepo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseAdminController
{
    protected const _VIEW_DASHBOARD = 'view-admin.backoffice.dashboard.dashboard';
    protected const _VIEW_ERROR = 'view-etc.errors';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        try {
            $adminRepo = new AdminRepo();
            $roleMenuMapping = $adminRepo->getAllMenuByRoleId(Auth::user()->default_role_id);
        
            $result = [
                'roleMenuMapping' => $roleMenuMapping,
                'menuOpen' => EnumMenus::_DASHBOARD_ID,
            ];
            return view($this::_VIEW_DASHBOARD)->with($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(EnumViewPageAdmin::ERROR, $th);
        }
    }

}
