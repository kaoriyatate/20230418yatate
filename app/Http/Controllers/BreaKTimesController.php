<?php

namespace App\Http\Controllers;
;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BreakTime;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendancesController;

class BreaKTimesController extends Controller
{

 

    public function store(Request $request)
    {
        

        $attendance_id = $request->input('attendance_id');
        $attendance = Attendance::find($attendance_id);
        $break_start_time = $request->input('break_start_time', Carbon::now('Asia/Tokyo')->toDateTimeString());


    
           
        $break_time = new BreakTime();
        $break_time->attendance_id = $attendance_id;
        $break_time->break_start_time = $break_start_time;
        $break_time->save();
        

        return redirect()->back()->with('success', '休憩開始を記録しました。');

    }
    


    public function update(Request $request)
    {

        $break_time = BreakTime::whereNull('break_end_time')->first();

        if (empty($break_time->break_start_time)) {
            return redirect()->back();

        }    
    
        
        $break_time->break_end_time = $request->input('break_end_time', Carbon::now('Asia/Tokyo')->toDateString());    
        $break_time->save();

        

        return redirect()->back()->with('success', '休憩終了を記録しました。');

        

    }

}
