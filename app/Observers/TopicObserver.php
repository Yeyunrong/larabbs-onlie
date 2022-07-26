<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;
use Illuminate\Support\Facades\DB;
//use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    //保存时数据处理
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    //保存后的处理
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    /**
     * 当监听到话题被删除时将话题下的回复也将删除
     */
    public function delete(Topic $topic)
    {
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
