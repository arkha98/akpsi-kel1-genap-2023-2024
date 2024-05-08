<?php

namespace Database\Seeders;

use App\EnumHelpers\EnumRoles;
use App\Helpers\CustomHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUser();
    }

    private function seedUser()
    {
        $user_arr = collect(
            [
                [
                    'id' => '4f791c4d-63fd-4f2b-a5be-b1cdb61a0458',
                    'full_name' => 'Superadmin',
                    'email' => 'superadmin@ecomindo.com',
                    'username' => 'superadmin',
                    'slug_name' => 'superadmin_2024',
                    'password' => CustomHelper::hashPassword('123456ecom'),
                    'default_role_id' => EnumRoles::_SUPERADMIN_ID,

                    'created_by' => 'root',
                    'updated_by' => 'root',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]

        );

        foreach ($user_arr as $item) {
            if ($item) {
                $check_is_exist = DB::table('users')
                    ->select('id')
                    ->where('email', $item['email'])
                    ->first();
                if (!$check_is_exist) {
                    DB::table('users')->insert($item);
                }
            }
        }
    }
}
