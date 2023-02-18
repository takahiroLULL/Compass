@extends('layouts.sidebar')
<!-- スクール予約画面 -->
@section('content')
<div class="w-75 m-auto">
  <div class="w-100">
    <p>{{ $calendar->getTitle() }}</p> <!--右上の〇〇〇〇年○月-->
    <p>{!! $calendar->render() !!}</p><!--カレンダー-->
  </div>
</div>
@endsection