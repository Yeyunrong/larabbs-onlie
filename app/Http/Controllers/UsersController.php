<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    /**
     * 构造器方法
     */
    public function __construct()
    {
        // 第一个是中间件名称， 第二个是要进行过滤的动作
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * 处理个人页面显示
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 编辑
     */
    public function edit(User $user)
    {
        //启用授权验证
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * 处理表单提交
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        //启用授权验证
        $this->authorize('update', $user);

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
