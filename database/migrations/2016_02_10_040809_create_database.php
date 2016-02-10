<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password', 255);
            $table->timestamps();
        });

        Schema::create('Plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->text('description');
            $table->string('capital', 10);
            $table->timestamps();
        });

        Schema::create('Monthly', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id');
            $table->string('income', 10);
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('Daily', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('monthly_id');
            $table->date('date');
            $table->string('expense');
            $table->string('income');
            $table->timestamps();
        });

        Schema::create('Finance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('daily_id');
            $table->integer('category_id');
            $table->text('description');
            $table->string('name');
            $table->string('amount');
            $table->integer('type');
            $table->timestamps();
        });

        Schema::create('Restrict', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id');
            $table->integer('category_id');
            $table->string('exceed');
            $table->timestamps();
        });

        Schema::create('Category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
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
