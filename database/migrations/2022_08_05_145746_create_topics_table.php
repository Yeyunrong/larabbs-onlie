<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	public function up()
	{
		Schema::create('topics', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('标题');
            $table->text('body')->comment("HTML样式");
            $table->bigInteger('user_id')->unsigned()->index()->comment('用户标识');
            $table->integer('category_id')->unsigned()->index()->comment('分类标识');
            $table->integer('reply_count')->unsigned()->default(0)->comment('回复数量');
            $table->integer('view_count')->unsigned()->default(0)->comment('浏览数');
            $table->integer('last_reply_user_id')->unsigned()->default(0)->comment('最后回复的用户标识');
            $table->integer('order')->unsigned()->default(0)->comment('订阅');
            $table->text('excerpt')->nullable()->comment('内容');
            $table->string('slug')->nullable()->comment('SEO优化标题翻译');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('topics');
	}
};
