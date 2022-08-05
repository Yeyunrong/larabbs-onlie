<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 数据分类模型
 */
class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * 允许维护的字段
     */
    protected $fillable = [
        'name', 'description',
    ];
}
