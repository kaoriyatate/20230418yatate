<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BreakTime;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\CarbonInterval;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Pagination\Paginator;





class AttendancesController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $attendance = Attendance::first();
        $break_times = BreakTime::all();
        $date = Carbon::today();
        
        
        
        

        if (Auth::check()){ 
            return view('stamp', ['attendance'=> $attendance, 'break_times'=> $break_times, 'user'=> $user, 'date'=> $date]);
        }  
        else {
            return view('auth/login');
        }
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $attendance = new Attendance();
        $attendance->user_id = $user_id;
        $attendance->attendance_date = $request->input('attendance_date', Carbon::now('Asia/Tokyo')->toDateString());
        $attendance->start_time = $request->input('start_time', Carbon::now('Asia/Tokyo')->toDateString());
        $attendance->save();

            
        return redirect()->back()->with('success', '出勤時間を記録しました。');
        
    }


    
    public function update(Request $request)
    {

        
        
        $attendance = Auth::user()->attendances()->latest('id')->first();
        
        
        if (empty($attendance->start_time)) {
            return redirect()->back()->with('error', '出勤時間が記録されていません。');
        }

        $attendance->attendance_date = $request->input('attendance_date', Carbon::now('Asia/Tokyo')->toDateString());
        $end_time = $request->input('end_time', Carbon::now('Asia/Tokyo')->toTimeString());
        
        

        if (!$end_time) {
            $end_time = Carbon::now('Asia/Tokyo')->toTimeString();
        }

        // 退勤時間が出勤時間と異なる日付であれば、退勤時間を当日の23:59:59に設定する
        $start_time = Carbon::parse($attendance->start_time);
        $end_time = Carbon::parse($end_time);
        if ($start_time->day != $end_time->day) {
            $end_time = $end_time->copy()->endOfDay();

        }

        // 日をまたいでいる場合は次のレコードに00:00:00から記録する
        $start_time = Carbon::parse($attendance->start_time);
        $end_time = Carbon::parse($end_time);
        if ($start_time->day != $end_time->day) {
            $next_day = $start_time->copy()->addDay();
            $next_day_start = Carbon::create($next_day->year, $next_day->month, $next_day->day, 0, 0, 0, $start_time->timezone);
            $attendance->end_time = $next_day_start->copy()->endOfDay()->toDateTimeString();
        
            $newAttendance = new Attendance();
            $newAttendance->attendance_date = $next_day_start->toDateString();
            $newAttendance->start_time = $next_day_start->toDateTimeString();
            $newAttendance->end_time = $end_time->copy()->startOfDay()->toDateTimeString();
            $newAttendance->user_id = $attendance->user_id;
            $newAttendance->save();
        } else {
            $attendance->end_time = $end_time;
        }    
        

        $attendance->attendance_date = $request->input('attendance_date', Carbon::now('Asia/Tokyo')->toDateString());
        $attendance->end_time = $end_time;
        $attendance->total_work_duration = null; 
        $attendance->total_break_duration = null;

        
        // 休憩時間の合計を計算する
        $break_times = BreakTime::where('attendance_id', $attendance->id)->get();
        $totalBreakDuration = 0;
        foreach ($break_times as $break) {
            $break_start_time = Carbon::parse($break->break_start_time);
            $break_end_time = Carbon::parse($break->break_end_time);
            if ($break_start_time->day !=      $break_end_time->day) { // 日付をまたいでいる場合
                $totalBreakDuration += $break_start_time->diffInSeconds($break_start_time->copy()->endOfDay()) + $break_start_time->copy()->startOfDay()->diffInSeconds($break_end_time) + $break_end_time->diffInSeconds($break_end_time->copy()->startOfDay());
                
            } else {
                $totalBreakDuration += $break_start_time->diffInSeconds($break_end_time);
            }
        }
        $attendance->total_break_duration = $totalBreakDuration;    

        // 勤務時間を計算する
        $startTime = Carbon::parse($attendance->start_time);
        $endTime = Carbon::parse($attendance->end_time);
        if($startTime->day !=$endTime->day){
            $totalWorkDuration = $startTime->diffInSeconds($startTime->copy()->endOfDay()) + $startTime->copy()->startOfDay()->diffInSeconds($endTime) + $endTime->diffInSeconds($endTime->copy()->startOfDay());
        } else {
            $totalWorkDuration = $startTime->diffInSeconds($endTime);
        }     

        $attendance->total_work_duration = $totalWorkDuration;


            $attendance->save();

        return redirect()->back()->with('success', '退勤時間を記録しました。');
    }

    
    
    
    
    public function show($date)
    {
        $date = Carbon::parse($date);
        $attendances = Attendance::where('attendance_date', $date->format('Y-m-d'))->with('user')->paginate(5);

        $user = User::get();
        

        $today = Carbon::parse($date);
        $prev = $today->copy()->subDay();
        $next = $today->copy()->addDay();

        $prevFormatted = $prev->format('Y-m-d');
        $nextFormatted = $next->format('Y-m-d');

        $attendance_date = Carbon::today()->format('Y-m-d');



        $attendance = DB::table('attendances')
                        ->where('attendance_date', $attendance_date)
                        ->get()
                        ->first(); 
        
        
        
        $data = [

            'date' => $date,
            'today' => $today,
            'prevFormatted' => $prevFormatted,
            'nextFormatted' => $nextFormatted,
            'attendances' => $attendances,
            'user' => $user,
            'attendance_date' => $attendance_date,
        

        ];

        
        return view('date',$data);
    
        
    }        
            
}    