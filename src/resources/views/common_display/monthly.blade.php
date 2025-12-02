@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/monthly.css') }}">
@endsection

@section('content')
<div class="attendance-list-wrapper">

    <h1 class="page-title">
        勤怠一覧
    </h1>

    <div class="month-nav">
        <a class="btn-month" href="{{ route('attendance.list', ['month' => $prevMonth]) }}">← 前月</a>

        <div class="month-display">
            📅 {{ $current->format('Y/m') }}
        </div>

        <a class="btn-month" href="{{ route('attendance.list', ['month' => $nextMonth]) }}">翌月 →</a>
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
                    $h = floor($breakMin / 60);
                    $m = $breakMin % 60;
                    @endphp
                    {{ $h . ':' . sprintf('%02d', $m) }}
                    @endif
                </td>

                {{-- 合計 --}}
                <td>
                    @if(!$isFuture && $hasClockOut && !$hasBreakUnfinished)
                    @php
                    $totalMin = $attendance->total_working_minutes;
                    $h = floor($totalMin / 60);
                    $m = $totalMin % 60;
                    @endphp
                    {{ $h . ':' . sprintf('%02d', $m) }}
                    @endif
                </td>

                {{-- 詳細 --}}
                <td>
                    @if($isFuture)
                    {{-- 未来日は 押せないグレー表示 --}}
                    <button class="btn-detail btn-disabled" disabled>詳細</button>
                    @else
                    {{-- 今日以前は 通常表示 --}}
                    <button class="btn-detail">詳細</button>
                    @endif
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>

</div>
@endsection