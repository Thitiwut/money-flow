<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUserNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('User', function ($table) {
            $table->integer('notification')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('User', function ($table) {
            $table->dropColumn('notification');
        });
    }
}
