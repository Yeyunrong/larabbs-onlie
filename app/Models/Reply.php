<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 回复模型
 */
class Reply extends Model
{
    use HasFactory;

    //只允许修改 内容 字段
    protected $fillable = ['content'];

    /**
     * 返回关联的话题信息
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 返回关联的用户信息
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
