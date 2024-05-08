<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseAdminController;
use Closure;
use Illuminate\Http\Request;

class checkActionMenuPrivilage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $menuid, $ColumnflagToCheck = '')
    {
        $baseAdmin = new BaseAdminController;
        if(!$baseAdmin->checkMenuPrivilage($menuid, $ColumnflagToCheck)){
            return redirect()->route('admin.dashboard.index');
        }
        return $next($request);
    }
}
