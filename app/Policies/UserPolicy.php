<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * 用来管理用户模型的授权策略
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 当两个id相同时，则代表两个用户时相同用户，用户通过授权，可以接着进行下一个操作。
     * 如果id不相同的话，将抛出403异常信息来拒绝访问。
     * $currentUser 默认为当前登录用户实例
     * $user 要进行授权的用户实例
     */
    public function update(User $currentUser, User $user)
    {
        // 1.我们并不需要检查 $currentUser 是不是NULL。未登录用户，框架会自动为其 所有权限 返回 false。
        // 2.调用时，默认情况下，我们不需要传递当前登录用户至该方法内，因为框架会自动加载当前登录用户。
        return $currentUser->id === $user->id;
    }
}
