@php
$layout = auth()->user()->role === 1
? 'layouts.app_admin'
: 'layouts.app';
@endphp

@extends($layout)

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/request_detail.css') }}">
@endsection

@section('content')

<div class="attendance-list-wrapper">

    <h1 class="page-title">勤怠詳細</h1>

    <table class="attendance-table">
        <tbody>

            {{-- 名前 --}}
            <tr>
                <th>名前</th>
                <td>{{ $correction->targetUser->name }}</td>
            </tr>

            {{-- 日付 --}}
            <tr>
                <th>日付</th>
                <td>
                    @if($afterCorrection)
                    @php
                    $date = \Carbon\Carbon::parse($afterCorrection->after_work_date);
                    @endphp
                    <span class="date-year">{{ $date->format('Y年') }}</span>
                    <span class="date-month">{{ $date->format('n月') }}</span>
                    <span class="date-day">{{ $date->format('j日') }}</span>
                    @endif
                </td>
            </tr>

            {{-- 出勤・退勤 --}}
            <tr>
                <th>出勤・退勤</th>
                <td>
                    @if($afterCorrection && $afterCorrection->after_clock_in)
                    {{ \Carbon\Carbon::parse($afterCorrection->after_clock_in)->format('H:i') }}
                    @endif
                    <span class="time-separator">～</span>
                    {{ \Carbon\Carbon::parse($afterCorrection->after_clock_out)->format('H:i') }}
                </td>
            </tr>

            {{-- 休憩（複数） --}}
            @foreach($afterBreaks as $i => $break)
            <tr>
                <th>{{ $i === 0 ? '休憩' : '' }}</th>
                <td>
                    {{ \Carbon\Carbon::parse($break->after_break_start)->format('H:i') }}
                    <span class="time-separator">～</span>
                    {{ \Carbon\Carbon::parse($break->after_break_end)->format('H:i') }}
                </td>
            </tr>
            @endforeach

            {{-- 備考 --}}
            <tr>
                <th>備考</th>
                <td>{{ $correction->reason }}</td>
            </tr>

        </tbody>
    </table>

    {{-- ===== 下部メッセージ・ボタン制御 ===== --}}
    <div class="detail-footer">

        {{-- 管理者 ＋ 承認待ち → 承認ボタン表示 --}}
        @if(auth()->user()->role === 1 && !$isApproved)
        <form method="POST"
            action="{{ route('admin.request.approve', ['id' => $correction->id]) }}">
            @csrf
            <button type="submit" class="btn-edit">
                承認
            </button>
        </form>

        {{-- 管理者 ＋ 承認済み ＋ 承認済みタブから来た → 何も表示しない --}}
        @elseif(auth()->user()->role === 1 && $isApproved && ($fromApprovedTab ?? false))
        {{-- 表示なし --}}

        {{-- 管理者 ＋ 承認済み（承認ボタン押下後など）→ 承認済みグレーボタン表示 --}}
        @elseif(auth()->user()->role === 1 && $isApproved)
        <button class="btn-edit btn-disabled" disabled>
            承認済み
        </button>

        {{-- ユーザー ＋ 承認待ち → メッセージ表示 --}}
        @elseif(auth()->user()->role !== 1 && !$isApproved)
        <p class="pending-message">
            @php
            $typeText = match($correction->type) {
            0 => '追加',
            1 => '修正',
            2 => '削除',
            default => '',
            };
            @endphp
            ＊ 「{{ $typeText }}」承認待ちのため修正はできません。
        </p>

        {{-- それ以外 → 何も出さない --}}
        @else
        {{-- 表示なし --}}
        @endif
    </div>

</div>

@endsection