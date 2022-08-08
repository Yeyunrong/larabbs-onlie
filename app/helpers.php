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
