<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\FrontendManage\Database\Seeders\FrontendManageDatabaseSeeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Modules\SystemSetting\Database\Seeders\SystemSettingDatabaseSeeder::class);
    }
}
