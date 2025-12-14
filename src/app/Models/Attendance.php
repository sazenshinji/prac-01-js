<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    // 勤怠ステータス定数
    public const STATUS_OFF     = 0; // 勤務外
    public const STATUS_WORKING = 1; // 出勤中
    public const STATUS_BREAK   = 2; // 休憩中
    public const STATUS_DONE    = 3; // 退勤済

    public const STATUS_LABELS = [
        self::STATUS_OFF     => '勤務外',
        self::STATUS_WORKING => '出勤中',
        self::STATUS_BREAK   => '休憩中',
        self::STATUS_DONE    => '退勤済',
    ];

    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in',
        'clock_out',
        'status',
    ];

    protected $dates = [
        'work_date',
        'clock_in',
        'clock_out',
    ];

    // ユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 休憩（既存）
    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class);
    }

    // 修正申請
    public function corrections()
    {
        return $this->hasMany(Correction::class);
    }

    // ステータスラベル
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? '不明';
    }

    // 休憩合計（分）
    public function getBreakTotalMinutesAttribute()
    {
        return $this->breaktimes
            ->sum(function ($break) {
                if (!$break->break_end) return 0;
                return Carbon::parse($break->break_start)
                    ->diffInMinutes(Carbon::parse($break->break_end));
            });
    }

    // 勤務合計（分）
    public function getWorkTotalMinutesAttribute()
    {
        if (!$this->clock_in || !$this->clock_out) return 0;
        return Carbon::parse($this->clock_in)
            ->diffInMinutes(Carbon::parse($this->clock_out));
    }

    // 実働時間（勤務 − 休憩）
    public function getTotalWorkingMinutesAttribute()
    {
        return max(0, $this->work_total_minutes - $this->break_total_minutes);
    }
}
