<?php

namespace Database\Seeders;

use App\EnumHelpers\EnumRoles;
use App\Enums\EnumRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedRoles();
    }

    private function seedRoles()
    {
        $role_akun_arr = collect(
            [
                [
                    'id' => EnumRoles::getIdByCode(EnumRoles::_SUPERADMIN),
                    'role_slug' => EnumRoles::_SUPERADMIN,
                    'role_name' => EnumRoles::_SUPERADMIN,
                    'is_active' => true,
                    'created_by' => 'root',
                    'updated_by' => 'root',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => EnumRoles::getIdByCode(EnumRoles::_SUPPORT_UNIT),
                    'role_slug' => EnumRoles::_SUPPORT_UNIT,
                    'role_name' => EnumRoles::_SUPPORT_UNIT,
                    'is_active' => true,
                    'created_by' => 'root',
                    'updated_by' => 'root',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );

        foreach ($role_akun_arr as $item) {
            if ($item) {
                $check_is_exist = DB::table('tb_roles')
                    ->select('role_slug')
                    ->where('role_slug', $item['role_slug'])
                    ->first();
                if (!$check_is_exist) {
                    DB::table('tb_roles')->insert($item);
                }
            }
        }
    }
}
