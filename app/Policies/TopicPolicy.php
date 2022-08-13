<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    /**
     * 修改提交权限限制用户本人
     */
    public function update(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 删除权限限制用户本人
     */
    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
