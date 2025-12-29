@php
$layout = auth()->user()->role === 1
? 'layouts.app_admin'
: 'layouts.app';
@endphp

@extends($layout)

@section('css')
<link rel="stylesheet" href="{{ asset('css/monthly.css') }}">
@endsection

@section('content')
<div class="attendance-list-wrapper">

    <h1 class="page-title">
        @if(auth()->user()->role === 1 && isset($targetUser))
        {{ $targetUser->name }}さんの勤怠
        @else
        勤怠一覧
        @endif
    </h1>

    @php
    // 管理者がスタッフの勤怠を見ている場合
    if(auth()->user()->role === 1 && isset($targetUser)) {
    $baseRoute = 'admin.attendance.staff';
    $routeParam = ['id' => $targetUser->id];
    }
    // 一般ユーザーが自分の勤怠を見ている場合
    else {
    $baseRoute = 'attendance.list';
    $routeParam = [];
    }
    @endphp

    <div class="month-nav">
        <a class="btn-month"
            href="{{ route($baseRoute, array_merge($routeParam, ['month' => $prevMonth])) }}">
            ← 前月
        </a>

        <div class="month-display">
            📅 {{ $current->format('Y/m') }}
        </div>

        <a class="btn-month"
            href="{{ route($baseRoute, array_merge($routeParam, ['month' => $nextMonth])) }}">
            翌月 →
        </a>
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dates as $item)

            @php
            $date = $item['date'];
            $attendance = $item['attendance'];
            $isFuture = $date->gt($today);

            $hasClockOut = $attendance && $attendance->clock_out;
            $hasBreakUnfinished = $attendance && $attendance->breaktimes->contains(function ($b) {
            return $b->break_end === null;
            });
            @endphp

            <tr>
                {{-- 日付 --}}
                <td>
                    {{ $date->format('m/d') }}
                    ({{ ['日','月','火','水','木','金','土'][$date->dayOfWeek] }})
                </td>

                {{-- 出勤 --}}
                <td>
                    @if(!$isFuture && $attendance)
                    {{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}
                    @endif
                </td>

                {{-- 退勤 --}}
                <td>
                    @if(!$isFuture && $hasClockOut && !$hasBreakUnfinished)
                    {{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}
                    @endif
                </td>

                {{-- 休憩 --}}
                <td>
                    @if(!$isFuture && $hasClockOut && !$hasBreakUnfinished)
                    @php
                    $breakMin = $attendance->break_total_minutes;
                    $hours = floor($breakMin / 60);
                    $minutes = $breakMin % 60;
                    @endphp
                    {{ $hours . ':' . sprintf('%02d', $minutes) }}
                    @endif
                </td>

                {{-- 合計 --}}
                <td>
                    @if(!$isFuture && $hasClockOut && !$hasBreakUnfinished)
                    @php
                    $totalMin = $attendance->total_working_minutes;
                    $hours = floor($totalMin / 60);
                    $minutes = $totalMin % 60;
                    @endphp
                    {{ $hours . ':' . sprintf('%02d', $minutes) }}
                    @endif
                </td>

                {{-- 詳細 --}}
                <td>
                    @if($isFuture)
                    {{-- 未来日は 押せない --}}
                    <span class="btn-detail btn-disabled">詳細</span>
                    @else

                    @if(auth()->user()->role === 1 && isset($targetUser))
                    {{-- 管理者がスタッフの勤怠を見ているとき --}}
                    <a class="btn-detail"
                        href="{{ route('admin.attendance.detail', [
                           'user' => $targetUser->id,
                           'date' => $date->format('Y-m-d')
                       ]) }}">
                        詳細
                    </a>
                    @else
                    {{-- 一般ユーザーが自分の勤怠を見ているとき --}}
                    <a class="btn-detail"
                        href="{{ route('attendance.detail', [
                           'date' => $date->format('Y-m-d')
                       ]) }}">
                        詳細
                    </a>
                    @endif

                    @endif
                </td>

            </tr>

            @endforeach

        </tbody>
    </table>

    {{-- ★ 管理者がスタッフの勤怠を見ている場合だけ CSV ボタンを表示 --}}
    @if(auth()->user()->role === 1 && isset($targetUser))
    <div class="csv-export-wrapper">
        <a href="{{ route('admin.attendance.staff.csv', [
            'id' => $targetUser->id,
            'month' => $current->format('Y-m')
               ]) }}" class="csv-btn">
            CSV出力
        </a>
    </div>
    @endif

</div>
@endsection