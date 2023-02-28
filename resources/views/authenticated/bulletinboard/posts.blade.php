@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area">
        <div class="d-flex post_status">
          <div class="mr-5">
            @foreach($post->subCategories as $category)
              <span class="category_btn">{{$category->sub_category}}</spna>
            @endforeach
          </div>
          <div class="post_comment">
            <i class="fa fa-comment">{{$post->postComments->count()}}</i>
            <div class="post-nice">
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span></p>
            @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <!-- <div class="btn btn-primary w-100"><a href="{{ route('post.input') }}">投稿</a></div>   元あった記述-->
      <input type="submit" class="btn btn-primary w-100" value="投稿" form="postCreate">
      <div class="post_keyword">
        <input type="text" style="height:35px" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="btn btn-primary" style="height:35px" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}">
          <span class="slide-button slide_num{{ $category->id }}"></span>
          <span>{{ $category->main_category }}</span>
        </li>
        @foreach($category->subCategories as $sub_category)
        <p class="sub_categories category_num{{ $sub_category->main_category_id }}">
          <input type="submit" name="sub_category" class="category_btn" value="{{$sub_category->sub_category}}" form="postSearchRequest">
        </p>
          @endforeach
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
  <form action="{{ route('post.input') }}" method="get" id="postCreate"></form>
</div>
@endsection