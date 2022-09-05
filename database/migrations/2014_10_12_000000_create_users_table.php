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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('用户表');
            $table->id()->comment("用户标识");
            $table->string('name')->comment("用户名");
            $table->string('email')->unique()->comment("邮箱");
            $table->timestamp('email_verified_at')->nullable()->comment("邮箱激活时间");
            $table->string('password')->comment("密码");
            $table->string('remember_token')->comment("记住我Token");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
