<?php

namespace Database\Seeders;

use App\EnumHelpers\EnumMenus;
use App\Helpers\CustomHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->delete();
        $this->seedMenus();
    }

    private function delete()
    {
        DB::table('tb_menus')
            ->delete();
    }

    private function seedMenus()
    {        

        foreach (EnumMenus::getAllCode() as $item) {
            if ($item) {
                $check_is_exist = DB::table('tb_menus')
                    ->select('menu_code')
                    ->where('menu_code', $item)
                    ->first();
                if (!$check_is_exist) {
                    DB::table('tb_menus')->insert([
                        'id' => EnumMenus::getIdByCode($item),
                        'menu_code' => $item,
                        'menu_slug' => EnumMenus::getSlugByCode($item),
                        'menu_name' => $item,
                        'created_by' => 'root',
                        'updated_by' => 'root',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
