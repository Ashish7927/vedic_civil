<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpColumnInCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'cp_name')) {
                $table->integer('cp_name')->default('0');
            }
            if (!Schema::hasColumn('certificates', 'cp_position_x')) {
                $table->integer('cp_position_x')->default('0');
            }
            if (!Schema::hasColumn('certificates', 'cp_position_y')) {
                $table->integer('cp_position_y')->default('0');
            }
            if (!Schema::hasColumn('certificates', 'cp_font_family')) {
                $table->string('cp_font_family', 191)->collation('utf8mb4_unicode_ci')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'cp_font_size')) {
                $table->integer('cp_font_size')->default('40');
            }
            if (!Schema::hasColumn('certificates', 'cp_font_color')) {
                $table->string('cp_font_color', 191)->collation('utf8mb4_unicode_ci')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            //
        });
    }
}
