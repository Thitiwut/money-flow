<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdatePlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Plan', function (Blueprint $table) {
            $table->dropColumn('capital');
            $table->integer('budget');
            $table->integer('target');
            $table->integer('expected');
        });

        Schema::table('Monthly', function (Blueprint $table) {
            $table->dropColumn('income');
            $table->integer('month');
            $table->integer('limit');
            $table->integer('progress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
