<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

// タイトルを出力する
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダーの出力
  function render(){
    // $htmlの中に入れてる
    $html = [];
    $html[] = '<div class="calendar text-center">'; //センター揃え
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks(); //週カレンダー１ヶ月分（1日〜31日）
    foreach($weeks as $week){     
                                    
      $html[] = '<tr class="'.$week->getClassName().'">';//週カレンダーオブジェクトを使ってHTMLのクラス名を出力

      $days = $week->getDays();//週カレンダーオブジェクトから、日カレンダーオブジェクトの配列を取得
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");//初日
        $toDay = $this->carbon->copy()->format("Y-m-d");//今日
        //      初日が今日より後        と     今日より後の日       
        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){
          $html[] = '<td class="calendar-td '.$day->pastClassName().'">';//灰色１n
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();//日本に合わせた今日の日
//もしログインしてる人が予約していたら、、、
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-70" style="font-size:12px">'.$reservePart .'参加</p>';//何部参加を表示
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'">'. $reservePart .'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        }else{//予約してなかったら
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){//予約していない人（過去）
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{//予約してない人（今日いこう）
          $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    // 初日
    $firstDay = $this->carbon->copy()->firstOfMonth();
    // 月末まで
    $lastDay = $this->carbon->copy()->lastOfMonth();
    // １周目                一週目の1日を指定
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    // 作業用の日  初日     +7日        週の開始に移動する
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    // 月末までループさせる
    //     初日〜〜〜〜 月末
    while($tmpDay->lte($lastDay)){
      // 週カレンダーviewを作成する
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      // 次の週=+7日する
      $tmpDay->addDay(7);
    }
    return $weeks;//ここまで全部$weeksに入った。
  }
}