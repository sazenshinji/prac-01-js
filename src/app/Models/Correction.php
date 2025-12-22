<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Correction extends Model
{
    use HasFactory;

    protected $fillable = [
        'operate_user_id',
        'target_user_id',
        'attendance_id',
        'type',
        'reason',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // 申請者
    public function operateUser()
    {
        return $this->belongsTo(User::class, 'operate_user_id');
    }

    // 対象ユーザー
    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    // 修正対象の勤怠
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    // 修正後（1対1）
    public function afterCorrection()
    {
        return $this->hasOne(AfterCorrection::class);
    }

    // 修正前（1対1）
    public function beforeCorrection()
    {
        return $this->hasOne(BeforeCorrection::class);
    }
}
