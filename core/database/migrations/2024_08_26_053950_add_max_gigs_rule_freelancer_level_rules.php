<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freelancer_level_rules', function (Blueprint $table) {
            $table->integer('max_gigs')->nullable()->defaultValue(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('freelancer_level_rules', function (Blueprint $table) {
            $table->dropColumn('max_gigs');
        });
    }
};
