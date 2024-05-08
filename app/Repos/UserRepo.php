<?php

namespace App\Repos;

use App\Helpers\CustomHelper;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepo{

    protected $model;
    public function __construct()
    {
        $this->model = new User();
    }

    public function getDataById($id)
    {
        return $this->model->find($id);
    }

    public function paginationAdmin($params, $getType, $sort, $sortBy, $currentPage, $dataPerPage, &$count)
    {
        $data = DB::table('users')
                    ->leftJoin('tb_user_roles', 'users.id', '=', 'tb_user_roles.user_id')
                    ->leftJoin('tb_roles', 'tb_user_roles.role_id', '=', 'tb_roles.id')
                    ->select(
                        'users.id',
                        'users.full_name',
                        'users.username',
                        'users.slug_name',
                        'users.email',
                        'users.profile_picture',
                        'tb_user_roles.role_id',
                        'tb_roles.role_name',
                        'users.is_active',
                        'users.created_at',
                        'users.updated_at'
                    )
                    ->distinct();

        $data= $this->filterByParams($data, $params);
        $count = $data->get()->count();
        
        if($sortBy == 'created_at'){
            $sortBy = 'users.created_at';
        }
        
        if($getType == 'pagination'){
            $data = CustomHelper::doPagination(
                    $data,
                    $sort,
                    $sortBy,
                    $currentPage,
                    $dataPerPage
                );
        }
        else{
            $data =$data->orderBy($sortBy, $sort);
        }
        
        return $data->get();
    }

    protected function filterByParams($data, $params)
    {

        if(isset($params['full_name']) && !empty($params['full_name'])){
            $data = $data->whereRaw("lower(users._full_name) LIKE '%". strtolower($params['name'])."%'");
        }
        if(isset($params['role_id']) && !empty($params['role_id'])){
            $data = $data->where("tb_user_roles.role_id",$params['role_id']);
        }
        if(isset($params['is_active']) && !empty($params['is_active'])){
            $data = $data->where("users.is_active",$params['is_active']);
        }

        return $data;
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
