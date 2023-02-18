$(function(){
  $('.js-modal-open').on('click',function(){
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();//js-modalで囲まれたものを出す。
    // 押されたボタンから投稿内容を取得し変数へ格納
    var day = $(this).attr('day');

    var reservePartNumber = $(this).attr('reservePartNumber');

    var reservePart = $(this).attr('reservePart');

    $('.day').text(day);

    $('.reservePart').text(reservePart);//リモ○部

    $('.day_id').val(day);//予約した日

    $('.reservePart_id').val(reservePartNumber);//部数の値


    //.->クラス名を表す
    return false;
});

// 背景部分や閉じるボタン(js-modal-close)が押されたら発火
$('.js-modal-close').on('click',function(){
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
});
});
