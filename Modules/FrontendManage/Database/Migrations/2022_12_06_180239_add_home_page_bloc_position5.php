<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddHomePageBlocPosition5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* create new sections */
        DB::table('homepage_block_positions')->insert([
            'block_name' => 'Corporate Access Promo Section',
            'order' => 18,
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('homepage_block_positions')->insert([
            'block_name' => 'Homepage Advertisement',
            'order' => 19,
            'created_at' => now(),
            'updated_at' => now(),

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('homepage_block_positions')->where('block_name', 'Corporate Access Promo Section')->delete();
        DB::table('homepage_block_positions')->where('block_name', 'Homepage Advertisement')->delete();
    }
}
