<?php

namespace App\Services\Admin;

use App\Helpers\CustomHelper;
use App\Helpers\FileHelper;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\Biodata;
use App\Models\StaffBiodata;
use App\Repos\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileManagementService{

    protected $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepo();
    }

    public function update(Request $request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateUpdate($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_UPDATE_DATA);
            }

            try {
                DB::beginTransaction();
                $data = $this->userRepo->getDataById(Auth::user()->id);
                $data->full_name = $request->full_name;
                
                $data = $this->userRepo->doUpdate($data, Auth::user()->id);

                $biodata = StaffBiodata::where('user_id', Auth::user()->id);
                if($biodata){
                    $biodata->nik = $request->input('nik');
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
                'user' => new UserProfileResource($data)
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function updatePassword(Request $request, $authUser)
    {
        $errors = [];
        try {
            $errors = $this->validateUpdatePassword($request, $authUser);
            if(count($errors) > 0){
                return CustomHelper::returnResultError($errors, CustomHelper::_ERROR_MESSAGE_UPDATE_DATA);
            }

            $data = $this->userRepo->getDataById(Auth::user()->id);
            $data->password = CustomHelper::hashPassword($request->new_password);
            $data->password_hint = $request->password_hint;
            $data = $this->userRepo->doUpdate($data, Auth::user()->id);
            $result = [
                'user' => new UserProfileResource($data)
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public function show(Request $request)
    {
        try {
            $data = $this->userRepo->getDataById(Auth::user()->id);

            $result = [
                'user' => (new UserResource($data))->resolve()
            ];

            return CustomHelper::returnResultBasic($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    #region VALIDATION

    private function validateUpdate($request, $authUser)
    {
        $rules = [
            'full_name' => 'required|min:5|max:50',
            // 'email' => [
            //     'required',
            //     'max:100',
            //     Rule::unique('users', 'email')->ignore($request->id)
            // ],
            'profile_picture' => 'nullable|image|file|max:2000',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'nik' => 'required',
            'phone_number' => 'required',
            'ktp_address' => 'required',
            'domicile_address' => 'required',
        ];

        $messages = [];

        $customAtrributes = [];

        $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);
        return $validator->errors();
    }

    private function validateUpdatePassword($request, $authUser)
    {
        $rules = [
            'old_password' => 'required|min:6|max:50',
            'new_password' => ['required', Password::min(8)->letters()->numbers()->mixedCase()],
            'new_password_again' => 'required|min:8|max:50',
            'password_hint' => 'nullable|max:150'
        ];

        $messages = [
            'id.exists' => 'user not found'
        ];

        $customAtrributes = [
            'old_password' => 'Old password',
            'new_password' => 'New password',
            'new_password_again' => 'Password Match',
            'password_hint' => 'Password hint'
        ];

        $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);

        if(count($validator->errors()) == 0){
            $data = $this->userRepo->getDataById($authUser->id);
            if(!Hash::check(CustomHelper::saltPassword($request->old_password), $data->password, [])){
                $validator->errors()->add('password', 'old password doesnt match');
            }

            if($request->new_password != $request->new_password_again){
                $validator->errors()->add('new_password_again', 'new password doesnt match');
            }
        }

        return $validator->errors();
    }

    #endregion
}
