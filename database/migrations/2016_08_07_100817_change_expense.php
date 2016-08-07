<?php

use Illuminate\Database\Migrations\Migration;

class ChangeExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Daily', function ($table) {
            $table->decimal('expense', 7, 2)->change();
            $table->decimal('income', 7, 2)->change();
        });
        Schema::table('Finance', function ($table) {
            $table->decimal('amount', 7, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Daily', function ($table) {
            $table->integer('expense')->change();
            $table->integer('income')->change();
        });
        Schema::table('Finance', function ($table) {
            $table->integer('amount')->change();
        });
    }
}
