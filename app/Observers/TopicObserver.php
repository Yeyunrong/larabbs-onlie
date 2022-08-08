<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    /**
     * 当帖子字段发生保存事件时，对 excerpt 字段进行赋值
     */
    public function saving(Topic $topic)
    {
        //make_excerpt 是自定义辅助函数 位于helpers.php
        $topic->excerpt = make_excerpt($topic->body);
    }
}
