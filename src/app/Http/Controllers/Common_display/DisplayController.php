<?php

namespace App\Http\Controllers\Common_display;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Correction;
use App\Models\AfterCorrection;
use App\Models\AfterBreak;
use App\Models\User;
use App\Http\Requests\DetailRequest;

class DisplayController extends Controller
{
    /**
     * 月次勤怠一覧（ユーザー・管理者 共通）
     */
    public function monthly(Request $request)
    {
        $user = Auth::user();
        $month = $request->query('month');
        $current = $month ? Carbon::parse($month) : Carbon::now();

        $start = $current->copy()->startOfMonth();
        $end   = $current->copy()->endOfMonth();
        $today = Carbon::today();

        $attendanceMap = Attendance::with('breaktimes')
            ->where('user_id', $user->id)
            ->whereBetween('work_date', [$start, $end])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->work_date)->format('Y-m-d');
            });

        $dates = [];
        $date = $start->copy();
        while ($date <= $end) {
            $key = $date->format('Y-m-d');
            $dates[] = [
                'date' => $date->copy(),
                'attendance' => $attendanceMap[$key] ?? null,
            ];
            $date->addDay();
        }

        return view('common_display.monthly', [
            'dates'      => $dates,
            'current'    => $current,
            'prevMonth'  => $current->copy()->subMonth()->format('Y-m'),
            'nextMonth'  => $current->copy()->addMonth()->format('Y-m'),
            'today'      => $today,
        ]);
    }

    /**
     * 勤怠詳細表示
     */
    public function detail(Request $request)
    {
        $user = Auth::user();
        $date = Carbon::parse($request->date);

        $attendance = Attendance::with('breaktimes')
            ->where('user_id', $user->id)
            ->where('work_date', $date->format('Y-m-d'))
            ->first();

        $breaks = $attendance
            ? $attendance->breaktimes()->orderBy('break_start')->get()
            : collect();

        // ★ 承認待ちチェック
        $isPending = Correction::where('target_user_id', $user->id)
            ->where('status', 0)
            ->whereHas('aftercorrection', function ($q) use ($date) {
                $q->whereDate('after_work_date', $date->format('Y-m-d'));
            })
            ->exists();

        return view('common_display.detail', compact(
            'user',
            'date',
            'attendance',
            'breaks',
            'isPending'
        ));
    }

    /**
     * 修正申請
     */
    public function update(DetailRequest $request)
    {
        $user = Auth::user();
        $date = Carbon::parse($request->input('date'));
        $action = $request->input('action'); // edit / delete

        $attendance = Attendance::with('breaktimes')
            ->where('user_id', $user->id)
            ->where('work_date', $date->format('Y-m-d'))
            ->first();

        // 二重申請防止
        $alreadyPending = Correction::where('target_user_id', $user->id)
            ->where('status', 0)
            ->whereHas('aftercorrection', function ($q) use ($date) {
                $q->whereDate('after_work_date', $date->format('Y-m-d'));
            })
            ->exists();

        if ($alreadyPending) {
            return back()->with('error', '承認待ちの申請があるため修正できません。');
        }

        // 種別判定
        if (!$attendance) {
            $type = 0; // 新規
        } elseif ($action === 'delete') {
            $type = 2; // 削除
        } else {
            $type = 1; // 修正
        }

        // corrections
        $correction = Correction::create([
            'operate_user_id' => $user->id,
            'target_user_id'  => $user->id,
            'attendance_id'   => $attendance?->id,
            'type'            => $type,
            'reason'          => $request->input('reason', ''),
            'status'          => 0,
            'approved_at'     => null,
        ]);

        $workDate = $date->format('Y-m-d');

        // aftercorrections
        $clockIn  = $request->input('clock_in');
        $clockOut = $request->input('clock_out');

        $afterCorrection = AfterCorrection::create([
            'correction_id'   => $correction->id,
            'after_work_date' => $workDate,
            'after_clock_in'  => $clockIn  ? Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $clockIn)  : null,
            'after_clock_out' => $clockOut ? Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $clockOut) : null,
        ]);

        // afterbreaks
        $allBreaks = [];

        foreach ($request->input('breaks', []) as $row) {
            if (!empty($row['start']) && !empty($row['end'])) {
                $allBreaks[] = $row;
            }
        }

        $extra = $request->input('extra_break', []);
        if (!empty($extra['start']) && !empty($extra['end'])) {
            $allBreaks[] = $extra;
        }

        foreach ($allBreaks as $index => $row) {
            AfterBreak::create([
                'after_correction_id' => $afterCorrection->id,
                'break_index'        => $index + 1,
                'after_break_start' => Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $row['start']),
                'after_break_end'   => Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $row['end']),
            ]);
        }

        return redirect()
            ->route('attendance.list', ['month' => $date->format('Y-m')])
            ->with('success', '修正申請を登録しました。');
    }

    /**
     * 削除申請（削除ボタン用）
     */
    public function delete(Request $request)
    {
        $request->merge(['action' => 'delete']);
        return $this->update($request);
    }

    public function adminDetail($userId, $date)
    {
        $user = User::findOrFail($userId);
        $date = Carbon::parse($date);

        $attendance = Attendance::with('breaktimes')
            ->where('user_id', $user->id)
            ->where('work_date', $date->format('Y-m-d'))
            ->first();

        $breaks = $attendance
            ? $attendance->breaktimes()->orderBy('break_start')->get()
            : collect();

        // 管理者は常に編集不可
        $isPending = true;

        return view('common_display.detail', compact(
            'user',
            'date',
            'attendance',
            'breaks',
            'isPending'
        ));
    }

    /**
     * 申請一覧（ユーザー用）
     * /stamp_correction_request/list
     */
    public function requestList(Request $request)
    {
        $user = Auth::user();

        // タブ：pending / approved（デフォルト：pending）
        $tab = $request->query('tab', 'pending');
        if (!in_array($tab, ['pending', 'approved'], true)) {
            $tab = 'pending';
        }

        // 対象ユーザーの申請を取得
        $corrections = Correction::with('aftercorrection')
            ->where('target_user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pending  = $corrections->where('status', 0);
        $approved = $corrections->where('status', 1);

        return view('common_display.request_list', [
            'user'     => $user,
            'tab'      => $tab,
            'pending'  => $pending,
            'approved' => $approved,
        ]);
    }
}
