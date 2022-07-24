{{--消息提醒模块--}}
@foreach (['danger', 'warning', 'success', 'info'] as $item)
    @if (session()->has($msg))
        <div class="flash-message">
          <p class="alert alert-{{ $msg }}">
            {{ session()->get($msg) }}
          </p>
        </div>
    @endif
@endforeach
