<?php

namespace App\Http\Controllers\Admin;

use App\EnumHelpers\EnumContentDynamicGroup;
use App\EnumHelpers\EnumMenus;
use App\Helpers\CustomHelper;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\GlobalFileMapping;
use App\Models\GlobalImageMapping;
use App\Models\GlobalThumbnailMapping;
use App\Services\Admin\ContentDynamicManagementService;
use App\Services\Admin\UserCompetitiveGrantManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserCompetitiveGrantController extends Controller
{
    protected $userCompetitiveGrantManagementService;

    protected const _VIEW_CONTENT_HOME = 'view-admin.modules.user-competitive-grant-management.index';
    protected const _VIEW_CONTENT_ADD = 'view-admin.modules.user-competitive-grant-management.add';
    protected const _VIEW_CONTENT_SHOW = 'view-admin.modules.user-competitive-grant-management.show';
    protected const _VIEW_CONTENT_EDIT = 'view-admin.modules.user-competitive-grant-management.edit';

    public function __construct() {
        $this->userCompetitiveGrantManagementService = new UserCompetitiveGrantManagementService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = $this->userCompetitiveGrantManagementService->index(request(), Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_CONTENT_HOME, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_CONTENT_HOME, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_CONTENT_HOME, $th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $result = $this->userCompetitiveGrantManagementService->add(request(), Auth::user());
            return CustomHelper::returnViewWithData(self::_VIEW_CONTENT_ADD, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_CONTENT_ADD, $th);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = [];
        try {
            $result = $this->userCompetitiveGrantManagementService->store($request, Auth::user());
            if (count($result['errors']) == 0) {
                return redirect()->route('admin.user-competitive-grant.index')
                    ->with('status', 'Data berhasil dibuat.');
            } else {
                return redirect()->back()->withErrors($result['errors'])->withInput();
            }
        } catch (\Throwable $th) {
            return CustomHelper::RedirectBackWithErrorException($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $params = ['id' => $id];
            $request->merge ($params);

            $result = $this->userCompetitiveGrantManagementService->show($request, Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_CONTENT_SHOW, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_CONTENT_SHOW, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_CONTENT_SHOW, $th);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            $request->merge(['id' => $id]);

            $result = $this->userCompetitiveGrantManagementService->show($request, Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_CONTENT_EDIT, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_CONTENT_EDIT, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_CONTENT_EDIT, $th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge(['id' => $id]);

            $result = $this->userCompetitiveGrantManagementService->update($request, Auth::user());
            if(count($result['errors']) == 0){
                return redirect()->route('admin.user-competitive-grant.index')
                            ->with('status','update successfully.');
            }
            else{
                return redirect()->back()->withErrors($result['errors'])->withInput();
            }
        } catch (\Throwable $th) {
            return CustomHelper::RedirectBackWithErrorException($th);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    #region API

    public function apiPagination(Request $request)
    {
        try {
            $filters = [
                'activity_title' => $request->input('is_active', null)
            ];

            if(UserHelper::checkRestrictReadUser(
                EnumMenus::_USER_COMPETITIVE_GRANT_ID, 
                Auth::user()->id)
                && UserHelper::isPeserta(Auth::user()->id)
                )
            {
                $filters['author_id'] = Auth::user()->id;
            }

            $custom = CustomHelper::defaultParamPagination($filters, $request);
            // $request->request->add($custom);
            $request->merge($custom);

            $result = $this->userCompetitiveGrantManagementService->pagination($request, Auth::user());

            return CustomHelper::basicResponse($result);
        } catch (\Throwable $th) {
            return CustomHelper::throwErrorResponse($th);
        }
    }

    public function apiGetFile(Request $request, $id, $mediaServerName) {
        try {
            if(!$mediaServerName) return '';
            if(!$id) return '';

            $data = $this->userCompetitiveGrantManagementService->getFile($request, $mediaServerName);
            if(!$data) return '';

            $path = storage_path() . "/app/public/competitive_grants/" . $mediaServerName;
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = response()->make($file, 200);
            $response->header("Content-Type", $type);
            
            return $response;
        } catch (\Throwable $th) {
            return CustomHelper::throwErrorResponse($th);
        }
    }

    #endregion
}
