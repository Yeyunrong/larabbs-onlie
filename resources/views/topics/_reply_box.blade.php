{{--回复框--}}
@include('shared._error')

<div class="reply-box">
  <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
    {{--回复框默认提示--}}
    <div class="mb-3">
      <textarea class="form-control" name="content" rows="3" placeholder="分享你的见解"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">
      <i class="fa fa-share mr-1"></i>
      回复
    </button>
  </form>
</div>
