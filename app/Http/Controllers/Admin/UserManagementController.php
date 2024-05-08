<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\UserManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserManagementController extends Controller
{
    protected $userManagementService;

    protected const _VIEW_MENU_HOME = 'view-admin.modules.user-management.index';
    protected const _VIEW_MENU_ADD = 'view-admin.modules.user-management.add';
    protected const _VIEW_MENU_SHOW = 'view-admin.modules.user-management.show';
    protected const _VIEW_MENU_EDIT = 'view-admin.modules.user-management.edit';
    protected const _VIEW_MENU_EDIT_PASSWORD = 'view-admin.modules.user-management.change-password';

    public function __construct() {
        $this->userManagementService = new UserManagementService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = $this->userManagementService->index(request(), Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_MENU_HOME, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_MENU_HOME, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_MENU_HOME, $th);
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
            $result = $this->userManagementService->add(request(), Auth::user());
            return CustomHelper::returnViewWithData(self::_VIEW_MENU_ADD, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_MENU_ADD, $th);
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

            $result = $this->userManagementService->store($request, Auth::user());
            if (count($result['errors']) == 0) {
                return redirect()->route('admin.user.index')
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
            $request->merge(['id' => $id]);

            $result = $this->userManagementService->show(request(), Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_MENU_SHOW, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_MENU_SHOW, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_MENU_SHOW, $th);
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

            $result = $this->userManagementService->show($request, Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_MENU_EDIT, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_MENU_EDIT, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_MENU_EDIT, $th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge(['id' => $id]);

            $result = $this->userManagementService->update($request, Auth::user());
            if(count($result['errors']) == 0){
                return redirect()->route('admin.user.index')
                            ->with('status','update successfully.');
            }
            else{
                return redirect()->back()->withErrors($result['errors'])->withInput();
            }
        } catch (\Throwable $th) {
            return CustomHelper::RedirectBackWithErrorException($th);
        }
    }

    public function editPassword(Request $request, $id)
    {
        try {
            $request->merge(['id' => $id]);

            $result = $this->userManagementService->showEditPassword($request, Auth::user());
            if(count($result['errors']) > 0){
                return CustomHelper::returnViewWithError(self::_VIEW_MENU_EDIT_PASSWORD, $result);
            }
            return CustomHelper::returnViewWithData(self::_VIEW_MENU_EDIT_PASSWORD, $result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(self::_VIEW_MENU_EDIT_PASSWORD, $th);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            $request->merge(['id' => $id]);

            $result = $this->userManagementService->updatePassword($request, Auth::user());
            if(count($result['errors']) == 0){
                return redirect()->route('admin.user.index')
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

    public function apiPagination(Request $request)
    {
        try {
            $filters = [
                'full_name' => $request->input('full_name', null),
                'is_active' => $request->input('is_active', null),
                'role_id' => $request->input('role_id', null)
            ];

            $custom = CustomHelper::defaultParamPagination($filters, $request);
            $request->merge($custom);

            $result = $this->userManagementService->pagination($request, Auth::user());

            return CustomHelper::basicResponse($result);
        } catch (\Throwable $th) {
            return CustomHelper::throwErrorResponse($th);
        }
    }

    public function apiGetPictureProfile(Request $request, $id, $profilePicture) {
        try {
            if(!$profilePicture) return '';
            if(!$id) return '';

            $data = User::where('id', $id)->where('profile_picture', $profilePicture)->first();
            if(!$data) return '';

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
