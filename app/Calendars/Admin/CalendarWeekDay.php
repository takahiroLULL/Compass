<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
    //部数を取ってきてる
    //$ymdは選択した日付

    $html[] = '<div class="text-left">';
    if($one_part){//一部のデータが全て入ってる
      $html[] = '<a href="' .route('calendar.admin.detail', ['id' => $one_part->id , 'data' => $one_part->setting_reserve , 'part' => $one_part->setting_part ] ). '" class="day_part m-0 pt-1"><p>1部</p></a>';
      $html[] = '<p class="day_part m-0 pt-1">'.$one_part->users()->count().'</p>';
    }
    if($two_part){
      $html[] = '<a href="/calendar/{id}/{data}/{part?}" class="day_part m-0 pt-1"><p>2部</p></a>';
    }
    if($three_part){
      $html[] = '<a href="/calendar/{id}/{data}/{part?}" class="day_part m-0 pt-1"><p>3部</p></a>';
    }
    $html[] = '</div>';
    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}


// /calendar/{id}/{$data->date}/{$one_part->part}

// 2/23試してみたこと
// $html[] = '<a href="/calendar/{id}/{$ymd->date}/{$one_part->part}" class="day_part m-0 pt-1"><p>1部</p></a>';　　うまくできない、ページは遷移できるがidは送れない