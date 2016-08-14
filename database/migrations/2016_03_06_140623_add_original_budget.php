<?php

use Illuminate\Database\Migrations\Migration;

class AddOriginalBudget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Plan', function ($table) {
            $table->integer('original');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Plan', function ($table) {
            $table->dropColumn('original');
        });
    }
}
