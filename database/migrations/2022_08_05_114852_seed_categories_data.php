<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 分类数据填充
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //需要插入的数据
        $categories = [
            [
                'name' => '分享',
                'description' => '分享创作，分享发现',
            ],
            [
                'name' => '教程',
                'description' => '开发技巧、推荐扩展包等',
            ],
            [
                'name' => '问答',
                'description' => '请保持友善，互帮互助',
            ],
            [
                'name' => '公告',
                'description' => '站点公告'
            ]
        ];

        //插入数据
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //数据回滚
        DB::table('categories')->truncate();
    }
};
