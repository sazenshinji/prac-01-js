<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class ConfirmController extends Controller
{
    /**
     * 管理者用：日次勤怠一覧
     */
    public function daily(Request $request)
    {
        // ?date=YYYY-MM-DD で受け取る（なければ今日）
        $dateParam = $request->query('date');
        $current = $dateParam ? Carbon::parse($dateParam) : Carbon::today();

        $today = Carbon::today();

        // 全ユーザーを取得
        $users = User::where('role', 0)->get();

        // 当日の勤怠を user_id をキーに Map 化
        $attendanceMap = Attendance::with('breaktimes')
            ->whereDate('work_date', $current)
            ->get()
            ->keyBy('user_id');

        // 表示用データ整形
        $rows = [];
        foreach ($users as $user) {
            $rows[] = [
                'user' => $user,
                'attendance' => $attendanceMap[$user->id] ?? null,
            ];
        }

        return view('admin.today', [
            'rows'      => $rows,
            'current'   => $current,
            'prevDate'  => $current->copy()->subDay()->format('Y-m-d'),
            'nextDate'  => $current->copy()->addDay()->format('Y-m-d'),
            'today'     => $today,
        ]);
    }
}
