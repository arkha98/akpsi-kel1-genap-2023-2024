<?php

namespace App\Repos;

use App\Helpers\CustomHelper;
use App\Models\UserRole;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRoleRepo{

    protected $model;
    public function __construct()
    {
        $this->model = new UserRole();
    }

    public function getDataById($id)
    {
        return $this->model->find($id);
    }

    public function getDataByUserid($userid)
    {
        return $this->model->where('user_id',$userid)->first();
    }

    public function getDataByUseridAndUserRole($userid, $userRoleId)
    {
        return $this->model
                    ->with('User')
                    ->with('UserRole')
                    ->where('user_id',$userid)
                    ->where('user_role_id',$userRoleId)
                    ->first();
    }

    public function store($params)
    {
        $data = $this->model->create($params);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->getDataById($id);
        $data->delete();
        return $data;
    }

    public function doUpdate($data, $user_id)
    {
        $data->updated_by = $user_id;
        $data->updated_at = now();
        $data->save();
        return $data;
    }
}
