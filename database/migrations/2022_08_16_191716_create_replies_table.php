<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	public function up()
	{
		Schema::create('replies', function(Blueprint $table) {
            $table->comment('话题回复表');
            $table->increments('id');
            $table->integer('topic_id')->unsigned()->default(0)->index()->comment('话题标识');
            $table->bigInteger('user_id')->unsigned()->default(0)->index()->comment('用户标识');
            $table->text('content')->comment('回复的内容');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('replies');
	}
};
