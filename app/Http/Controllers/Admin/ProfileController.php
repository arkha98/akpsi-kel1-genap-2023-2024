<?php

namespace App\Http\Controllers\Admin;

use App\EnumHelpers\EnumMenus;
use App\Helpers\CustomHelper;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProfileManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $profileManagementService;

    protected const _VIEW_PROFILE_HOME = 'view-admin.modules.profile.index';
    protected const _VIEW_PROFILE_EDIT = 'view-admin.modules.profile.edit';
    protected const _VIEW_PROFILE_EDIT_PASSWORD = 'view-admin.modules.profile.change-password';

    public function __construct() {
        $this->profileManagementService = new ProfileManagementService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = $this->profileManagementService->show(request());
            return CustomHelper::returnViewWithData(self::_VIEW_PROFILE_HOME, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_PROFILE_HOME, $th);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $result = $this->profileManagementService->show($request, Auth::user());
            return CustomHelper::returnViewWithData(self::_VIEW_PROFILE_EDIT, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_PROFILE_EDIT, $th);
        }
    }

    public function update(Request $request)
    {
        try {
            $result = $this->profileManagementService->update($request, Auth::user());
            if(count($result['errors']) == 0){
                return redirect()->route('admin.profile.index')
                            ->with('status','update successfully.');
            }
            else{
                return redirect()->back()->withErrors($result['errors'])->withInput();
            }
        } catch (\Throwable $th) {
            return CustomHelper::RedirectBackWithErrorException($th);
        }
    }

    public function editPassword(Request $request)
    {
        try {
            return CustomHelper::returnViewWithData(self::_VIEW_PROFILE_EDIT_PASSWORD, []);
        } catch (\Throwable $th) {
            return CustomHelper::RedirectBackWithErrorException($th);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $result = $this->profileManagementService->updatePassword($request, Auth::user());
            if(count($result['errors']) == 0){
                return redirect()->route('admin.profile.index')
                            ->with('status','update password successfully.');
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

    public function apiGetPictureProfile(Request $request, $mediaServerName) {
        try {
            $profilePicture = Auth::user()->profile_picture;
            if(!$profilePicture) return '';

            $path = storage_path() . "/app/public/profile_pictures/" . $profilePicture;
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
