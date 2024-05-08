<?php

namespace Database\Seeders;

use App\EnumHelpers\EnumMenus;
use App\EnumHelpers\EnumRoles;
use App\Enums\EnumMenu;
use App\Enums\EnumRole;
use App\Helpers\CustomHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleMenuMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->delete();
        $this->seedMenuAksesMappingSuperadmin();
        $this->seedMenuAksesMappingSupportUnit();
    }

    private function delete()
    {
        DB::table('tb_role_menus')
            ->delete();
    }

    private function seedMenuAksesMappingSuperadmin()
    {
        $mappingArr = [];
        foreach (EnumMenus::getAllCode() as $menuCode) {
            $temp = [
                'id' => Str::uuid(),
                'menu_id' => EnumMenus::getIdByCode($menuCode),
                'role_id' => EnumRoles::_SUPERADMIN_ID,
                'IS_ACTIVE' => true,
                'IS_READ_RESTRICT_USER' => false,
                'IS_CREATE' => true,
                'IS_CREATE_RESTRICT_USER' => false,
                'IS_UPDATE' => true,
                'IS_UPDATE_RESTRICT_USER' => false,
                'IS_DELETE' => true,
                'IS_DELETE_RESTRICT_USER' => false,
                'IS_DETAIL' => true,
                'IS_DETAIL_RESTRICT_USER' => false,

                'created_by' => 'root',
                'updated_by' => 'root',
                'created_at' => now(),
                'updated_at' => now()
            ];
            $mappingArr[] = $temp;
        }

        foreach ($mappingArr as $item) {
            if ($item) {
                $check_is_exist = DB::table('tb_role_menu_mappings')
                    ->select('id')
                    ->where('menu_id', $item['menu_id'])
                    ->where('role_id', $item['role_id'])
                    ->first();
                if (!$check_is_exist) {
                    DB::table('tb_role_menu_mappings')->insert($item);
                }
            }
        }
        
    }

    private function seedMenuAksesMappingSupportUnit()
    {
        $mappingArr = [];
        foreach (EnumMenus::getAllCodeForSupportUnit() as $menuCode) {
            $temp = [
                'id' => Str::uuid(),
                'menu_id' => EnumMenus::getIdByCode($menuCode),
                'role_id' => EnumRoles::_SUPPORT_UNIT_ID,
                'IS_ACTIVE' => true,
                'IS_READ_RESTRICT_USER' => true,
                'IS_CREATE' => true,
                'IS_CREATE_RESTRICT_USER' => true,
                'IS_UPDATE' => true,
                'IS_UPDATE_RESTRICT_USER' => true,
                'IS_DELETE' => true,
                'IS_DELETE_RESTRICT_USER' => true,
                'IS_DETAIL' => true,
                'IS_DETAIL_RESTRICT_USER' => true,

                'created_by' => 'root',
                'updated_by' => 'root',
                'created_at' => now(),
                'updated_at' => now()
            ];
            $mappingArr[] = $temp;
        }

        foreach ($mappingArr as $item) {
            if ($item) {
                $check_is_exist = DB::table('tb_role_menu_mappings')
                    ->select('id')
                    ->where('menu_id', $item['menu_id'])
                    ->where('role_id', $item['role_id'])
                    ->first();
                if (!$check_is_exist) {
                    DB::table('tb_role_menu_mappings')->insert($item);
                }
            }
        }
        
    }

}
