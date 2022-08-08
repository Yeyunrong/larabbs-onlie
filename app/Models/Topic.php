<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 话题列表
 */
class Topic extends Model
{
    use HasFactory;

    //允许修改的字段
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug',
    ];

    /**
     * 关联分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 关联用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 自定义-排序逻辑
     */
    public function scopeWithOrder($query, $order)
    {
        //不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                //最近的
                $query->recent();
                break;

            default:
                //最近回复
                $query->recentReplied();
                break;
        }
    }

    /**
     * 自定义-最近回复
     */
    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * 自定义-最近的
     */
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
}
