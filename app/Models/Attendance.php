<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BreakTime;
use Carbon\Carbon;


class Attendance extends Model
{
    use HasFactory;


    

    protected $fillable = [
        'user_id',
        'start_time',
        'attendance_date',
        'end_time',
        'total_break_duration',
        'total_work_duration'
    ];
    
    public function user()
    {
    return $this->BelongsTo(User::class);

    }

    public function break_times()
    {
        return $this->HasMany(BreakTime::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            // 休憩時間の合計を計算する
            $break_times = BreakTime::where('attendance_id', $attendance->id)->get();
            $totalBreakDuration = 0;
            foreach ($break_times as $break) {
                $break_start_time = Carbon::parse($break->break_start_time);
                $break_end_time = Carbon::parse($break->break_end_time);
                if ($break_start_time->day != $break_end_time->day) { // 日付をまたいでいる場合
                    $totalBreakDuration += $break_start_time->diffInSeconds(Carbon::parse($break_start_time->copy()->endOfDay()));
                    $totalBreakDuration += $break_end_time->diffInSeconds(Carbon::parse($break_end_time->copy()->startOfDay()));
                } else {
                    $break_duration = $break_start_time->diffInSeconds($break_end_time);
                    $totalBreakDuration += $break_duration;
                }
            }

            // 勤務時間を計算する
            if (!empty($attendance->end_time)) {
                $start_time = Carbon::parse($attendance->start_time);
                $end_time = Carbon::parse($attendance->end_time);
                $totalWorkDuration = $end_time->diffInSeconds($start_time) - $totalBreakDuration;

                $totalWorkDuration = gmdate('H:i:s', $totalWorkDuration);
                $totalBreakDuration = gmdate('H:i:s', $totalBreakDuration);

                $attendance->total_work_duration = $totalWorkDuration;
                $attendance->total_break_duration = $totalBreakDuration;
            }
        });
    }

}
