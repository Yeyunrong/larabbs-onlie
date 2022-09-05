<!DOCTYPE html>
{{-- 主要布局文件，项目的所有页面都继承于此页面 --}}
{{-- app()->getLocale() 获取的是 config/app.php 中的 locale 选项， str_replace()是将指定字符串中方的 '_' 替换成 '-' --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'Laravel 进阶实例') }}</title>
  <meta name="description" content="@yield('description', setting('seo_description', 'LaraBBS laravel项目展示。'))" />
  <meta name="keywords" content="@yield('keyword', setting('seo_keyword', 'Laravel,社区,论坛,开发者论坛'))" />

  <!-- Styles 加载样式 -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  {{-- 载入锚点 --}}
  @yield('styles')

</head>

<body>
  {{-- route_class() 是自定义的辅助函数，在helpers.php中 --}}
  <div id="app" class="{{ route_class() }}-page">
    {{-- 加载顶部导航区块的子模板 --}}
    @include('layouts._header')

    <div class="container">
      {{-- 消息提醒模块 --}}
      @include('shared._messages')
      {{-- 占位符声明，允许继承此模板的页面注入内容 --}}
      @yield('content')
    </div>
    {{-- 加载页面尾部导航区块的子模板 --}}
    @include('layouts._footer')
  </div>

  @if (app()->isLocal())
    @include('sudosu::user-selector')
  @endif

  <!-- Scripts 加载JS -->
  <script src="{{ mix('js/app.js') }}"></script>

  {{-- 载入锚点 --}}
  @yield('scripts')

</body>

</html>
