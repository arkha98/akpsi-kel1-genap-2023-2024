<?php

namespace Database\Seeders;

use App\EnumHelpers\EnumRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserRoleMappingSeeder extends Seeder
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
                    'id' => Str::uuid(),
                    'user_id' => '4f791c4d-63fd-4f2b-a5be-b1cdb61a0458',
                    'role_id' => EnumRoles::_SUPERADMIN_ID,
                    'is_active' => true,
                    'created_by' => 'root',
                    'updated_by' => 'root',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        );

        foreach ($role_akun_arr as $item) {
            if ($item) {
                $check_is_exist = DB::table('tb_role_user_mappings')
                    ->select('id')
                    ->where('user_id', $item['user_id'])
                    ->where('role_id', $item['role_id'])
                    ->first();
                if (!$check_is_exist) {
                    DB::table('tb_role_user_mappings')->insert($item);
                }
            }
        }
    }
}
