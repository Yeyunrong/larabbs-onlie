<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

/**
 * 队列任务
 */
class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    /**
     * Create a new job instance.
     * 构造函数
     * @return void
     */
    public function __construct(Topic $topic)
    {
        // 队列任务构造器中接收了 Eloquent模型，将会只序列化模型的ID
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     * 创建队列任务
     * @return void
     */
    public function handle()
    {
        //请求百度API接口翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        //为了避免模型监控器死循环调用，使用DB类直接对数据库操作；
        DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}
