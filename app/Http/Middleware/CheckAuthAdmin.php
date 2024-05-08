<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseAdminController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class CheckAuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $baseAdmin = new BaseAdminController;

        if(!$baseAdmin->checkAuth()){
            if($request->url() == route('admin.logout.action-logout')){
                return $next($request);
            }

            return redirect()->route('admin.login.index');
        }

        $latestSesiLogin = $baseAdmin->getLatestSesiLogin();
        if($latestSesiLogin){
            if(session('sesi_login_id', '') != $latestSesiLogin->id){
                $sts_msg = [
                    'status' => 0,
                    'message' => 'Sesi Anda Sudah Tidak Valid'
                ];
                $baseAdmin->clearLogout();
                return redirect()->route('admin.login.index')->with(['sts_msg' => $sts_msg])->send();
            }
        }

        return $next($request);
    }
}
