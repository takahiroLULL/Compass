@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<div class="modal js-modal">

  <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <p class="">予約日:
        <span class="modal_day" name="getPart"></span>
      </p>
      <p>時間:
        <span class="modal_reservePart" name="getDate"></span>
      </p>
      <!-- .はクラス名なのでnameではなく、classとやるのが正 -->
      <p>上記の予約をキャンセルしていいですか？</p>
        <div class="w-50 m-auto edit-modal-btn d-flex">
      <a class="js-modal-close btn btn-primary  d-inline-block" href="">閉じる</a>
      <input type="hidden" class="modal_reservePart_id " form ="deleteParts" name="reservePart_id">
      <input type="hidden" class="modal_day_id " form ="deleteParts" name="day_id">
      <input type="submit" class="btn btn-danger  d-inline-block" form ="deleteParts" onclick="return confirm('キャンセルしますか？')" value="キャンセル" >
        </div>
    </div>
  </div>
</div>
<form action = "/delete/calendar" method = "post" id ="deleteParts"><!--実はこれいらない。view.phpにあるから-->
@endsection