<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasApiTokens, HasFactory, MustVerifyEmailTrait;

    /**
     * 自定义消息通知
     */
    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //如果要通知的是用户自己，可以忽略
        if ($this->id == Auth::id())
        {
            return;
        }

        //只有数据库类型通知才需要，其他类型忽略
        if (method_exists($instance, 'toDatabase'))
        {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 用户模型关联话题
     */
    public function topics()
    {
        // 一对多关系
        return $this->hasMany(Topic::class);
    }

    /**
     * 是否是当前登录用户
     */
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 当前用户的所有回复
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 清除消息通知
     */
    public function markAsRead()
    {
        //消息数量为零后保存
        $this->notification_count = 0;
        $this->save();
        // 将未读标记为已读
        $this->unreadNotifications->markAsRead();
    }
}
