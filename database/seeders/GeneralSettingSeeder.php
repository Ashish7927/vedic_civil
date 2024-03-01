<?php

use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UpdateGeneralSetting('footer_copy_right', 'Copyright © 2022 e-LATiH All rights reserved |This application is made by  <a href="https://elatih.com" target="_blank"><font color="#D12053">My Live Learning</font></a>');

    }
}
