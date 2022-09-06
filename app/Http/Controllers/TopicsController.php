<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;
use App\Models\Link;

/**
 * 话题列表
 */
class TopicsController extends Controller
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        //限制未登录用户发帖
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * 首页处理
     * $request     请求参数
     * $topic       话题
     * $user        用户
     * $link        资源链接
     */
    public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)
                        ->with('user', 'category')  // 预加载防止 N+1 问题
                        ->paginate(20);
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    /**
     * 帖子页面展示处理
     */
    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    /**
     * 进入话题创建
     */
	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

    /**
     * 完成话题创建提交
     * $request     请求参数
     * $topic       一个空白的实例对象
     */
	public function store(TopicRequest $request, Topic $topic)
	{
        //fill() 用于将传参的键值数组填充到模型的属性中。
        $topic->fill($request->all());
		$topic->user_id = Auth::id();//获取当前登录的ID
        $topic->save();

		return redirect($topic->link())->with('success', '帖子创建成功！');
	}

    /**
     * 显示编辑页面
     */
	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

    /**
     * 处理提交的修改
     */
	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route($topic->link(), $topic->id)->with('success', '更新成功！');
	}

    /**
     * 删除帖子
     */
	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功！');
	}

    /**
     * 上传图片处理函数
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败',
            'file_path' => '',
        ];

        //判断是否有上传文件，并赋值给$file
        if ($file = $request->upload_file)
        {
            //保存图片到本地
            $result = $uploader->save($file, 'topices', Auth::id(), 1024);
            //图片保存成功
            if ($result)
            {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功！";
                $data['success'] = true;
            }
        }

        return $data;
    }
}
