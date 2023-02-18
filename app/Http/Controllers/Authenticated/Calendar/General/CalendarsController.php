<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        // 'time'=>現在時刻、今月のカレンダーを用意する
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();//DBに直接接続する。
        dd($request);
        try{
            $getPart = $request->getPart;//○日
            $getDate = $request->getData;//〇〇〇〇-〇〇-〇〇
            // getPart=getDate (○日=〇〇〇〇-〇〇-〇〇)
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request)
    {
        dd($request);
        $id = $request->day_id;
        $reservePart = $request->reservePart_id;
        // dd($id);
        // dd($reservePart);
        \DB::table('reserve_settings')
            ->where($reservePart, $id)
            ->delete();

            return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

}