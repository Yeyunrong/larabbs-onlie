<?php

use Illuminate\Support\Facades\Route;

/**
 * 此方法将当前请求的路由名称转换为 CSS 类名称， 作用是允许我们针对某个页面做页面样式定制。
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 顶部话题分类导航栏信息
 */
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

/**
 * 添加话题摘录，将作为文章页面的 description 元标签使用，有利于 SEO 搜索引擎优化。摘录由文章内容中自动生成，生成的时机是在话题数据存入数据库之前。
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str()->limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = str()->snake($class_name);

    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return str()->plural($snake_case_name);
}
