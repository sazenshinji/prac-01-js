@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/monthly.css') }}">
@endsection

@section('content')
<div class="attendance-list-wrapper">

    <h1 class="page-title">
        {{ $current->format('Y年n月j日') }} の勤怠
    </h1>

    <div class="date-nav">
        <a class="btn-month" href="{{ route('admin.daily', ['date' => $prevDate]) }}">← 前日</a>

        <div class="month-display">
            {{ $current->format('Y/m/d') }}
        </div>

        <a class="btn-month" href="{{ route('admin.daily', ['date' => $nextDate]) }}">翌日 →</a>
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th>名前</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)

            @php
            $user = $row['user'];
            $attendance = $row['attendance'];
            $isFuture = $current->gt($today);

            $hasClockOut = $attendance && $attendance->clock_out;
            $hasBreakUnfinished = $attendance && $attendance->breaktimes->contains(fn($b) => $b->break_end === null);
            @endphp

            <tr>
                {{-- 名前 --}}
                <td>{{ $user->name }}</td>

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
                    $m = $attendance->break_total_minutes;
                    echo floor($m / 60) . ':' . sprintf('%02d', $m % 60);
                    @endphp
                    @endif
                </td>

                {{-- 合計 --}}
                <td>
                    @if(!$isFuture && $hasClockOut && !$hasBreakUnfinished)
                    @php
                    $m = $attendance->total_working_minutes;
                    echo floor($m / 60) . ':' . sprintf('%02d', $m % 60);
                    @endphp
                    @endif
                </td>

                {{-- 詳細 --}}
                <td>
                    @if($isFuture)
                    <button class="btn-detail btn-disabled" disabled>詳細</button>
                    @else
                    <button class="btn-detail">詳細</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection