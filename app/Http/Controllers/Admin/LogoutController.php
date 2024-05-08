<?php

namespace App\Http\Controllers\Admin;

use App\EnumHelpers\EnumViewPageAdmin;
use App\Enums\EnumViewPage;
use App\Helpers\CustomHelper;
use App\Http\Controllers\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogoutController extends BaseAdminController
{

    public function __construct()
    {
    }

    public function actionLogout(Request $request){
        try {
            $this->clearLogout();
            return redirect()->route('admin.login.index');
            die;
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(EnumViewPageAdmin::ERROR, $th);
        }
    }

}
