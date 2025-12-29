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
use Illuminate\Support\Facades\DB;
use App\Models\BeforeCorrection;
use App\Models\BeforeBreak;

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

        // 承認待ちデータ取得
        $pendingCorrection = Correction::with([
            'afterCorrection.afterBreaks'
        ])
            ->where('target_user_id', $user->id)
            ->where('status', 0)
            ->whereHas('afterCorrection', function ($q) use ($date) {
                $q->whereDate('after_work_date', $date->format('Y-m-d'));
            })
            ->first();

        if ($pendingCorrection) {

            // 承認待ち → after 系
            $attendance = $pendingCorrection->afterCorrection;
            $breaks = $attendance
                ? $attendance->afterBreaks()->orderBy('break_index')->get()
                : collect();

            $isPending = true;

            // ★ 追加： reason,type を渡す
            $correctionReason = $pendingCorrection->reason;
            $pendingType = $pendingCorrection->type;
        } else {

            // 通常勤怠
            $attendance = Attendance::with('breaktimes')
                ->where('user_id', $user->id)
                ->where('work_date', $date->format('Y-m-d'))
                ->first();

            $breaks = $attendance
                ? $attendance->breaktimes()->orderBy('break_start')->get()
                : collect();

            $isPending = false;

            // 通常時は空文字
            $correctionReason = '';
            $pendingType = null;
        }

        return view('common_display.detail', compact(
            'user',
            'date',
            'attendance',
            'breaks',
            'isPending',
            'correctionReason',
            'pendingType'
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

    /**
     * 勤怠詳細表示(管理者)
     */
    public function adminDetail($userId, $date)
    {
        $user = User::findOrFail($userId);
        $date = Carbon::parse($date);

        $pendingCorrection = Correction::with([
            'afterCorrection.afterBreaks'
        ])
            ->where('target_user_id', $user->id)
            ->where('status', 0)
            ->whereHas('afterCorrection', function ($q) use ($date) {
                $q->whereDate('after_work_date', $date->format('Y-m-d'));
            })
            ->first();

        if ($pendingCorrection) {

            $attendance = $pendingCorrection->afterCorrection;
            $breaks = $attendance
                ? $attendance->afterBreaks()->orderBy('break_index')->get()
                : collect();

            $isPending = true;

            // 承認待ちreason,type
            $correctionReason = $pendingCorrection->reason;
            $pendingType = $pendingCorrection->type;
        } else {

            $attendance = Attendance::with('breaktimes')
                ->where('user_id', $user->id)
                ->where('work_date', $date->format('Y-m-d'))
                ->first();

            $breaks = $attendance
                ? $attendance->breaktimes()->orderBy('break_start')->get()
                : collect();

            $isPending = false;
            $correctionReason = '';
            $pendingType = null;
        }

        return view('common_display.detail', compact(
            'user',
            'date',
            'attendance',
            'breaks',
            'isPending',
            'correctionReason',
            'pendingType'
        ));
    }

    /**
     * 申請一覧（ユーザー・管理者 共通）
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

        // ============================
        // 管理者：全件
        // ユーザー：自分の申請のみ
        // ============================

        $query = Correction::with(['afterCorrection', 'targetUser'])
            ->orderBy('created_at', 'desc');

        if ($user->role !== 1) {
            // 一般ユーザー → 自分の申請のみ
            $query->where('target_user_id', $user->id);
        }

        $corrections = $query->get();

        $pending  = $corrections->where('status', 0);
        $approved = $corrections->where('status', 1);

        return view('common_display.request_list', [
            'user'      => $user,
            'tab'       => $tab,
            'pending'   => $pending,
            'approved'  => $approved,
            'isAdmin'   => $user->role === 1,   // Blade 側で使う判定
        ]);
    }

    public function requestDetail(Request $request, $id)
    {
        $user = Auth::user();

        // 承認済みタブ経由か？
        $fromApprovedTab = $request->query('tab') === 'approved';

        $query = Correction::with(['afterCorrection.afterBreaks', 'targetUser'])
            ->where('id', $id);

        if ($user->role !== 1) {
            $query->where('target_user_id', $user->id);
        }

        $correction = $query->firstOrFail();

        $afterCorrection = $correction->afterCorrection;

        $afterBreaks = $afterCorrection
            ? $afterCorrection->afterBreaks()->orderBy('break_index')->get()
            : collect();

        return view('common_display.request_detail', [
            'user'            => $user,
            'correction'      => $correction,
            'afterCorrection' => $afterCorrection,
            'afterBreaks'     => $afterBreaks,
            'isApproved'      => $correction->status === 1,

            'fromApprovedTab' => $fromApprovedTab,
        ]);
    }

    /**
     * 申請承認処理（管理者）
     */
    public function approve($id)
    {
        $correction = Correction::with([
            'afterCorrection.afterBreaks'
        ])->findOrFail($id);

        // 二重承認防止
        if ($correction->status === 1) {
            return back()->with('error', 'すでに承認済みです。');
        }

        DB::transaction(function () use ($correction) {

            $after = $correction->afterCorrection;
            $afterBreaks = $after->afterBreaks;

            // 現在の勤怠
            $attendance = Attendance::where('user_id', $correction->target_user_id)
                ->where('work_date', $after->after_work_date)
                ->first();

            // ============================================
            // ① before_corrections 退避
            // ============================================
            $beforeCorrection = $correction->beforeCorrection()->create([
                'before_work_date' => $attendance?->work_date,
                'before_clock_in'  => $attendance?->clock_in,
                'before_clock_out' => $attendance?->clock_out,
            ]);

            if ($attendance) {
                $attendance->breaktimes->each(function ($b) use ($beforeCorrection) {
                    $beforeCorrection->beforeBreaks()->create([
                        'break_index'         => $b->break_index,
                        'before_break_start' => $b->break_start,
                        'before_break_end'   => $b->break_end,
                    ]);
                });
            }

            // ============================================
            // ② corrections.type に応じて反映
            // ============================================
            if ($correction->type === 0) {
                // 新規
                $attendance = Attendance::create([
                    'user_id'   => $correction->target_user_id,
                    'work_date' => $after->after_work_date,
                    'clock_in'  => $after->after_clock_in,
                    'clock_out' => $after->after_clock_out,
                    'status'    => 3,
                ]);
            } elseif ($correction->type === 1) {
                // 修正
                $attendance->update([
                    'clock_in'  => $after->after_clock_in,
                    'clock_out' => $after->after_clock_out,
                    'status'    => 3,
                ]);

                $attendance->breaktimes()->delete();
            } elseif ($correction->type === 2) {
                // 削除
                $attendance?->delete();

                $correction->update([
                    'status'      => 1,
                    'approved_at' => now(),
                ]);
                return;
            }

            // ============================================
            // ③ breaktimes 再作成
            // ============================================
            $afterBreaks->each(function ($b) use ($attendance) {
                $attendance->breaktimes()->create([
                    'break_index' => $b->break_index,
                    'break_start' => $b->after_break_start,
                    'break_end'   => $b->after_break_end,
                ]);
            });

            // ============================================
            // ④ 承認確定
            // ============================================
            $correction->update([
                'status'      => 1,
                'approved_at' => now(),
            ]);
        });

        return back()->with('success', '申請を承認しました。');
    }

    public function adminImmediateUpdate(DetailRequest $request, $userId, $date)
    {
        $admin = Auth::user(); // 操作者（管理者）
        $targetUser = User::findOrFail($userId);
        $date = Carbon::parse($date);
        $action = $request->input('action'); // edit / delete

        DB::transaction(function () use ($admin, $targetUser, $date, $request, $action) {

            $workDate = $date->format('Y-m-d');

            $attendance = Attendance::with('breaktimes')
                ->where('user_id', $targetUser->id)
                ->where('work_date', $workDate)
                ->first();

            // ===== ① 種別判定 =====
            $type = !$attendance ? 0 : ($action === 'delete' ? 2 : 1);

            // ===== ② corrections 作成 =====
            $correction = Correction::create([
                'operate_user_id' => $admin->id,
                'target_user_id'  => $targetUser->id,
                'attendance_id'   => $attendance?->id,
                'type'            => $type,
                'reason'          => $request->input('reason', '管理者即時修正'),
                'status'          => 0,
                'approved_at'     => null,
            ]);

            // ===== ③ afterCorrection =====
            $after = $correction->afterCorrection()->create([
                'after_work_date' => $workDate,
                'after_clock_in'  => Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $request->clock_in),
                'after_clock_out' => Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $request->clock_out),
            ]);

            // ===== ④ afterBreaks =====
            collect(array_merge(
                $request->input('breaks', []),
                [$request->input('extra_break', [])]
            ))->filter(fn($b) => !empty($b['start']) && !empty($b['end']))
                ->values()
                ->each(function ($b, $i) use ($after, $workDate) {

                    $after->afterBreaks()->create([
                        'break_index'        => $i + 1,
                        'after_break_start' => Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $b['start']),
                        'after_break_end'   => Carbon::createFromFormat('Y-m-d H:i', $workDate . ' ' . $b['end']),
                    ]);
                });

            // ===== ⑤ beforeCorrection =====
            $before = $correction->beforeCorrection()->create([
                'before_work_date' => $attendance?->work_date,
                'before_clock_in'  => $attendance?->clock_in,
                'before_clock_out' => $attendance?->clock_out,
            ]);

            if ($attendance) {
                $attendance->breaktimes->each(function ($b) use ($before) {
                    $before->beforeBreaks()->create([
                        'break_index'         => $b->break_index,
                        'before_break_start' => $b->break_start,
                        'before_break_end'   => $b->break_end,
                    ]);
                });
            }

            // ===== ⑥ 勤怠へ即反映 =====
            if ($type === 0) {

                $attendance = Attendance::create([
                    'user_id'   => $targetUser->id,
                    'work_date' => $workDate,
                    'clock_in'  => $after->after_clock_in,
                    'clock_out' => $after->after_clock_out,
                    'status'    => 3,
                ]);
            } elseif ($type === 1) {

                $attendance->update([
                    'clock_in'  => $after->after_clock_in,
                    'clock_out' => $after->after_clock_out,
                    'status'    => 3,
                ]);

                $attendance->breaktimes()->delete();
            } else {

                $attendance?->delete();
            }

            if ($type !== 2) {
                $after->afterBreaks->each(function ($b) use ($attendance) {
                    $attendance->breaktimes()->create([
                        'break_index' => $b->break_index,
                        'break_start' => $b->after_break_start,
                        'break_end'   => $b->after_break_end,
                    ]);
                });
            }

            // ===== ⑦ 即承認 =====
            $correction->update([
                'status'      => 1,
                'approved_at' => now(),
            ]);
        });

        return redirect()
            ->route('admin.daily', ['date' => $date->format('Y-m-d')])
            ->with('success', '管理者による即時反映が完了しました。');
    }

    /**
     * 月次勤怠一覧（管理者によるスタッフ閲覧用）
     * /admin/attendance/staff/{id}?month=YYYY-MM
     */
    public function adminMonthly(Request $request, $id)
    {
        // 対象スタッフ
        $targetUser = User::findOrFail($id);

        // ?month=YYYY-MM（なければ今月）
        $month = $request->query('month');
        $current = $month ? Carbon::parse($month) : Carbon::now();

        $start = $current->copy()->startOfMonth();
        $end   = $current->copy()->endOfMonth();
        $today = Carbon::today();

        // 対象ユーザーの月次勤怠
        $attendanceMap = Attendance::with('breaktimes')
            ->where('user_id', $targetUser->id)
            ->whereBetween('work_date', [$start, $end])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->work_date)->format('Y-m-d');
            });

        // 1ヶ月分の日付配列
        $dates = [];
        $date = $start->copy();
        while ($date <= $end) {
            $key = $date->format('Y-m-d');
            $dates[] = [
                'date'       => $date->copy(),
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

            // ★ 管理者用表示のための追加情報
            'targetUser' => $targetUser,   // タイトル用（XXさんの勤怠）
        ]);
    }

    /**
     * 管理者用：スタッフ月次勤怠 CSV 出力（空の日も出力）
     * /admin/attendance/staff/{id}/csv?month=YYYY-MM
     */
    public function adminMonthlyCsv(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);

        // 対象月（なければ今月）
        $month = $request->query('month');
        $current = $month ? Carbon::parse($month) : Carbon::now();

        $start = $current->copy()->startOfMonth();
        $end   = $current->copy()->endOfMonth();

        // 月内の勤怠を Map 化（work_date => Attendance）
        $attendanceMap = Attendance::with('breaktimes')
            ->where('user_id', $targetUser->id)
            ->whereBetween('work_date', [$start, $end])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->work_date)->format('Y-m-d');
            });

        // CSV ヘッダー
        $csvData = [];
        $csvData[] = [
            '日付',
            '出勤',
            '退勤',
            '休憩',
            '合計',
        ];

        // 月初〜月末まで「必ず1日ずつ」出力
        $date = $start->copy();
        while ($date <= $end) {

            $key = $date->format('Y-m-d');
            $attendance = $attendanceMap[$key] ?? null;

            // 休憩時間（分 → H:MM 形式へ変換）
            $breakMinutes = $attendance?->break_total_minutes;
            if (!is_null($breakMinutes)) {
                $breakH = floor($breakMinutes / 60);
                $breakM = $breakMinutes % 60;
                $breakTime = sprintf('%d:%02d', $breakH, $breakM); // 例: 1:30
            } else {
                $breakTime = '';
            }

            // 合計労働時間（分 → H:MM 形式へ変換）
            $totalMinutes = $attendance?->total_working_minutes;
            if (!is_null($totalMinutes)) {
                $workH = floor($totalMinutes / 60);
                $workM = $totalMinutes % 60;
                $totalWorkTime = sprintf('%d:%02d', $workH, $workM); // 例: 7:30
            } else {
                $totalWorkTime = '';
            }

            // 曜日配列（Sun〜Sat → 日〜土）
            $weekMap = ['日', '月', '火', '水', '木', '金', '土'];

            // 日付＋曜日（例：2025-02-03(月)）
            $dateWithWeek = $date->format('Y-m-d') . '(' . $weekMap[$date->dayOfWeek] . ')';

            $csvData[] = [
                $dateWithWeek,   // ここが 曜日付き になる
                $attendance?->clock_in ? Carbon::parse($attendance->clock_in)->format('H:i') : '',
                $attendance?->clock_out ? Carbon::parse($attendance->clock_out)->format('H:i') : '',
                $breakTime,
                $totalWorkTime,
            ];

            $date->addDay();
        }

        // ファイル名
        $fileName = $targetUser->name . '_勤怠_' . $current->format('Y_m') . '.csv';

        // CSV ダウンロード設定
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($csvData) {
            $stream = fopen('php://output', 'w');

            // Excel 文字化け防止
            fwrite($stream, "\xEF\xBB\xBF");

            foreach ($csvData as $row) {
                fputcsv($stream, $row);
            }

            fclose($stream);
        };

        return response()->stream($callback, 200, $headers);
    }
}
