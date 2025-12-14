@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css//attendance.css') }}">
@endsection

@section('content')

<div class="attendance-wrapper">

    <div class="attendance-info">
        <div class="attendance-row">
            <span class="status-badge status-{{ $status }}">
                {{ \App\Models\Attendance::STATUS_LABELS[$status] ?? '不明' }}
            </span>
        </div>

        <div class="attendance-row">
            <span class="value attendance-date">
                {{ $today->translatedFormat('Y年m月d日') }}
                <span class="weekday">{{ $today->translatedFormat('（D）') }}</span>
            </span>
        </div>

        <div class="attendance-row">
            <span class="value" id="current-time">
                {{ now()->format('H:i') }}
            </span>
        </div>

        <div class="attendance-buttons">
            @if ($status === \App\Models\Attendance::STATUS_OFF)
            {{-- 勤務外 → 出勤ボタンのみ --}}
            <form method="POST" action="{{ route('attendance.clockIn') }}">
                @csrf
                <button type="submit" class="btn-primary">出勤</button>
            </form>

            @elseif ($status === \App\Models\Attendance::STATUS_WORKING)
            {{-- 勤務中 → 退勤 & 休憩入 --}}
            <form method="POST" action="{{ route('attendance.clockOut') }}">
                @csrf
                <button type="submit" class="btn-danger">退勤</button>
            </form>

            <form method="POST" action="{{ route('attendance.breakIn') }}">
                @csrf
                <button type="submit" class="btn-secondary">休憩入</button>
            </form>

            @elseif ($status === \App\Models\Attendance::STATUS_BREAK)
            {{-- 休憩中 → 休憩戻のみ --}}
            <form method="POST" action="{{ route('attendance.breakOut') }}">
                @csrf
                <button type="submit" class="btn-secondary">休憩戻</button>
            </form>

            @elseif ($status === \App\Models\Attendance::STATUS_DONE)
            {{-- 退勤済 → ボタンなし & メッセージ --}}
            <p class="finished-message">
                お疲れ様でした。
            </p>
            @endif
        </div>
    </div>
</div>

@endsection