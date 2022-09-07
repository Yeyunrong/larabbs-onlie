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
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Traits\LastActivedAtHelper;
    use HasRoles;
    use HasApiTokens, HasFactory, MustVerifyEmailTrait;
    use Traits\ActiveUserHelper;
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

    /**
     * 管理员页面操作用户 密码重置
     */
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    /**
     * 管理员页面操作用户 头像重置
     */
    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! Str::startsWith($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
}
