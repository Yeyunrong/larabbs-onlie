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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->comment('消息类型');
            //快速创建一个名称为 notifiable_id ，类型为 UNSIGNED BIGINT 的列
            //和一个名称为 notifiable_type ，类型为 VARCHAR 的列。
            $table->morphs('notifiable');
            $table->text('data')->comment('消息内容');
            $table->timestamp('read_at')->nullable()->comment('已读时间');
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
        Schema::dropIfExists('notifications');
    }
};
