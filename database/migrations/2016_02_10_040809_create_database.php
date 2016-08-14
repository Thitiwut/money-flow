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
            $table->string('username',255);
            $table->string('email',255);
            $table->string('password', 255);
            $table->timestamps();
        });

        Schema::create('Plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name',255);
            $table->text('description');
            $table->integer('budget');
            $table->integer('target');
            $table->integer('expected');
            $table->integer('period');
            $table->timestamps();
        });

        Schema::create('Monthly', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id');
            $table->integer('status');
            $table->integer('month');
            $table->integer('limit');
            $table->integer('progress');
            $table->timestamps();
        });

        Schema::create('Daily', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('monthly_id');
            $table->date('date');
            $table->integer('expense');
            $table->integer('income');
            $table->timestamps();
        });

        Schema::create('Finance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('daily_id');
            $table->integer('category_id');
            $table->text('description');
            $table->string('name');
            $table->integer('amount');
            $table->integer('type');
            $table->timestamps();
        });

        Schema::create('Restrict', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id');
            $table->integer('category_id');
            $table->integer('exceed');
            $table->integer('for');
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
        Schema::drop('User');
        Schema::drop('Plan');
        Schema::drop('Monthly');
        Schema::drop('Daily');
        Schema::drop('Finance');
        Schema::drop('Restrict');
        Schema::drop('Category');
    }
}
