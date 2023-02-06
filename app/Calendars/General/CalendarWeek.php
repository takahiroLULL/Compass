<?php
namespace App\Calendars\General;

use Carbon\Carbon;

class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName(){
    return "week-" . $this->index;//クラスをつけるメソッド　過去の日付とかを処理する
  }

  /**
   * @return
   */

   function getDays(){
     $days = [];

     $startDay = $this->carbon->copy()->startOfWeek();//週の開始日
     $lastDay = $this->carbon->copy()->endOfWeek();//週の終了日
     $tmpDay = $startDay->copy();//作業用の日
     while($tmpDay->lte($lastDay)){//開始日から終了日〜日曜日をループ
       if($tmpDay->month != $this->carbon->month){
         $day = new CalendarWeekBlankDay($tmpDay->copy());
         $days[] = $day;
         $tmpDay->addDay(1);
         continue;
        }
        $day = new CalendarWeekDay($tmpDay->copy());
        $days[] = $day;

        $tmpDay->addDay(1);
      }
      return $days;
    }
  }