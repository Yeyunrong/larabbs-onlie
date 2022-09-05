{{-- 回复列表 --}}
<ul class="list-unstyled">
  @foreach ($replies as $index=>$reply)
    <li class="d-flex" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
      <div class="media-left">
        {{-- 显示用户头像，并可以点击头像前往用户个人页面 --}}
        <a href="{{ route('users.show', [$reply->user_id]) }}">
          <img class="media-object img-thumbnail mr-3" src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" style="width:48px;height:48px">
        </a>
      </div>

      <div class="flex-grow-1 ms-2">
        {{-- 显示用户昵称 --}}
        <div class="media-heading mt-0 mt-1 text-secondary">
            <a class="text-decoration-none" href="{{ route('users.show', [$reply->user_id]) }}" title="{{ $reply->user->name }}">
              {{ $reply->user->name }}
            </a>
          <span class="text-secondary">
            •
          </span>
          {{-- 显示话题创建时间 --}}
          <span class="meta text-secondary" title="{{ $reply->created_at }}">
            {{ $reply->created_at->diffForHumans() }}
          </span>
          {{-- 回复删除按钮「只有作者和回复者才显示删除按钮」 --}}
          @can('destroy', $reply)
            <span class="meta float-end">
              <form action="{{ route('replies.destroy', $reply->id) }}" onsubmit="return confirm('确定要删除此评论？')" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button tyle="submit" class="btn btn-default btn-xs pull-left text-secondary">
                  <i class="far fa-trash-alt"></i>
                </button>
              </form>
            </span>
          @endcan
        </div>
        {{-- 回复内容 --}}
        <div class="reply-content text-secondary">
          {!! $reply->content !!}
        </div>
      </div>
    </li>

    @if ( ! $loop->last)
      <hr>
    @endif

@endforeach
</ul>
