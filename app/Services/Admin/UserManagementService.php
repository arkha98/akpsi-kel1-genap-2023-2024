<?php

namespace App\Services\Admin;

use App\Helpers\CustomHelper;
use App\Helpers\FileHelper;
use App\Http\Resources\UserPagingResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserShowResource;
use App\Models\Biodata;
use App\Models\Role;
use App\Repos\UserRepo;
use App\Repos\UserRoleRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserManagementService{

    protected $userRepo;
    protected $userRoleRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepo();
        $this->userRoleRepo = new UserRoleRepo();
    }

    public function index()
    {
        try {
            $roles = Role::all();
            $result = [
                'roles' => $roles
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function add($request, $authUser)
    {
        try {
            $roles = Role::all();
            $result = [
                'roles' => $roles
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function store($request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateStore($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_STORE_DATA);
            }

            $resultImageProfile = null;
            if($request->hasFile('profile_picture')){
                $resultImageProfile = FileHelper::uploadProfilePicture($request);
                if(isset($objectImage['status_message'])){
                    return CustomHelper::returnResultError($objectImage['errors'], CustomHelper::_ERROR_MESSAGE_STORE_DATA);
                }
            } 

            $slugName = Str::slug($request['full_name']) . '-' . uniqid();

            $param_data = [
                'full_name' => $request['full_name'],
                'slug_name' => $slugName,
                'email' => $request['email'],
                'password' => CustomHelper::hashPassword($request['password']),
                'password_hint' => $request['password_hint'],
                'profile_picture' => $resultImageProfile['media_server_name'] ?? null,
                'is_active' => $request['is_active'],
                'default_role_id' => $request['role_id'],
            ];
            $data = $this->userRepo->store($param_data);

            $param_data_mapping = [
                'user_id' => $data->id,
                'role_id' => $request['role_id']
            ];
            $this->userRoleRepo->store($param_data_mapping);

            $result = [
                'data' => (new UserResource($data))->resolve()
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function update($request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateUpdate($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_UPDATE_DATA);
            }

            $resultImageProfile = null;
            if($request->hasFile('profile_picture')){
                $resultImageProfile = FileHelper::uploadProfilePicture($request);
                if(isset($objectImage['status_message'])){
                    return CustomHelper::returnResultError($objectImage['errors'], CustomHelper::_ERROR_MESSAGE_UPDATE_DATA);
                }
            } 

            try {
                DB::beginTransaction();

                $data = $this->userRepo->getDataById($request->id);
                $data->full_name = $request['full_name'];
                $data->email = $request['email'];
                $data->is_active = $request['is_active'];
                $data->default_role_id = $request['role_id'];
                if($request->hasFile('profile_picture')){
                    $data->profile_picture = $resultImageProfile['media_server_name'];
                }
                $data = $this->userRepo->doUpdate($data, Auth::user()->id);

                $data_mapping = $this->userRoleRepo->getDataByUserid($request->id);
                $data_mapping->role_id = $request['role_id'];
                $userRole = $this->userRoleRepo->doUpdate($data_mapping, Auth::user()->id);

                $biodata = Biodata::where('user_id', Auth::user()->id);
                if($biodata){
                    $biodata->gender = $request->input('gender');
                    $biodata->birth_place = $request->input('birth_place');
                    $biodata->birth_date = $request->input('birth_date');
                    $biodata->nik = $request->input('nik');
                    $biodata->phone_number = $request->input('phone_number');
                    $biodata->ktp_address = $request->input('ktp_address');
                    $biodata->domicile_address = $request->input('domicile_address');
                    $biodata->updated_by = Auth::user()->id;
                    $biodata->updated_at = now();                    
                    $biodata->save();
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return CustomHelper::returnResultErrorThrowException($th);
            }
            

            $result = [
                'data' => (new UserResource($data))->resolve()
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function updatePassword($request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateUpdatePassword($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_UPDATE_DATA);
            }

            $data = $this->userRepo->getDataById($request->id);
            $data->password = CustomHelper::hashPassword($request['new_password']);
            $data->password_hint = $request['password_hint'];
            $data = $this->userRepo->doUpdate($data, Auth::user()->id);
            $result = [
                'data' => (new UserResource($data))->resolve()
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function showEditPassword($request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateShow($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_SHOW_DATA);
            }

            $data = $this->userRepo->getDataById($request->id);
            $actionToken = CustomHelper::hashPassword($data['id'].$data['slug_name']);
            $result = [
                'actionToken' => $actionToken,
                'data' => (new UserResource($data))->resolve()
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function show($request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateShow($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_SHOW_DATA);
            }

            $data = $this->userRepo->getDataById($request->id);
            $roles = Role::all();
            $result = [
                'roles' => $roles,
                'data' => (new UserResource($data))->resolve()
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function pagination($request, $authUser)
    {
        $errors = [];
        try {
            $count = 0;
            $data = $this->userRepo
                        ->paginationAdmin(
                            $request->params,
                            $request->getType,
                            $request->sort,
                            $request->sortBy,
                            $request->currentPage,
                            $request->dataPerPage,
                            $count
                        );

            if($data){            
                $data = json_decode(json_encode($data, true), true);
                $data = UserResource::collection($data)->resolve();
            }
           
            $result = CustomHelper::resultPagination(
                $request->params,
                $request->getType,
                $data,
                $count,
                $request->sort,
                $request->sortBy,
                $request->currentPage,
                $request->dataPerPage
            );

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    #region VALIDATION
    private function validateStore($request, $authUser)
    {
        $rules = [
            'full_name' => 'required|min:5|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => ['required', Password::min(8)->letters()->numbers()->mixedCase()],
            'password_again' => 'required|min:8|max:50',
            'password_hint' => 'nullable|max:100',
            'is_active' => 'required',
            'role_id' => 'required|exists:tb_roles,id',
            'profile_picture' => 'nullable|mimes:jpeg,bmp,png,jpg|max:2000',
        ];

        $messages = [];
        $customAtrributes = [
            'password_again' => 'Password matching',
            'password_hint' => 'Password hint',
            'role_id' => 'User Role'
        ];

        $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);

        if(count($validator->errors()) == 0){
            if($request->password != $request->password_again){
                $validator->errors()->add('password_again', 'new password doesnt match');
            }
        }

        return $validator->errors();
    }

    private function validateUpdate($request, $authUser)
    {
        $rules = [
            'id' => 'required|exists:users,id',
            'full_name' => 'required|min:5|max:50',
            'email' => [
                'required',
                'max:100',
                Rule::unique('users', 'email')->ignore($request->id)
            ],
            'is_active' => 'required',
            'role_id' => 'required|exists:tb_roles,id',
            'profile_picture' => 'nullable|mimes:jpeg,bmp,png,jpg|max:2000',
        ];

        $messages = [
            'id.exists' => 'user not found'
        ];

        $customAtrributes = [
            'role_id' => 'User Role'
        ];

        $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);
        if(count($validator->errors()) == 0){
        }
        return $validator->errors();
    }

    private function validateUpdatePassword($request, $authUser)
    {
        $rules = [
            'id' => 'required|exists:users,id',
            'new_password' => ['required', Password::min(8)->letters()->numbers()->mixedCase()],
            'new_password_again' => 'required|min:8|max:50',
            'password_hint' => 'max:100',
            'actionToken' => 'required'
        ];

        $messages = [
            'id.exists' => 'user not found'
        ];

        $customAtrributes = [
            'new_password' => 'New password',
            'new_password_again' => 'Password Match',
            'password_hint' => 'Password hint'
        ];

        $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);

        if(count($validator->errors()) == 0){

            $id = $request->input('id');
            $actionToken = $request->input('actionToken');

            $data = $this->userRepo->getDataById($id);
            $salt_password = CustomHelper::saltPassword($id . $data['slug_name']);
            if(!password_verify($salt_password, $actionToken)){
                $validator->errors()->add('password', 'failed');
            }

            if($request->new_password != $request->new_password_again){
                $validator->errors()->add('new_password_again', 'new password doesnt match');
            }
        }

        return $validator->errors();
    }

    private function validateShow($request, $authUser)
    {
        $rules = [
            'id' => 'required|exists:users,id'
        ];

        $messages = [
            'id.exists' => 'user not found'
        ];

        $customAtrributes = [
            'id' => 'User'
        ];

        $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);
        if(count($validator->errors()) == 0){

        }
        return $validator->errors();
    }

    private function validateDelete($request, $authUser)
    {
        $rules = [
            'id' => 'required|exists:users,id'
        ];

        $messages = [
            //'id.required' => 'category must be filled'
        ];

        $customAttributes = [
            'id' => 'Users'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if(count($validator->errors()) == 0){

        }

        return $validator->errors();

    }

    #endregion VALIDATION
}
