@php
$layout = auth()->user()->role === 1
? 'layouts.app_admin'
: 'layouts.app';
@endphp

@extends($layout)

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<div class="attendance-list-wrapper">

    @php
    $isToday = $date->isToday();
    @endphp

    <h1 class="page-title">勤怠詳細</h1>

    {{-- 修正・削除 共通フォーム --}}
    <form method="POST" action="{{ route('attendance.detail.update') }}" novalidate>
        @csrf

        {{-- 対象日 --}}
        <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">

        <table class="attendance-table">
            <tbody>

                {{-- 名前 --}}
                <tr>
                    <th>名前</th>
                    <td>{{ $user->name }}</td>
                </tr>

                {{-- 日付（表示のみ） --}}
                <tr>
                    <th>日付</th>
                    <td>
                        <span class="date-year">{{ $date->format('Y年') }}</span>
                        <span class="date-month">{{ $date->format('n月') }}</span>
                        <span class="date-day">{{ $date->format('j日') }}</span>
                    </td>
                </tr>

                {{-- 出勤・退勤 --}}
                <tr>
                    <th>出勤・退勤</th>
                    <td>
                        <input type="time" class="no-time-picker" name="clock_in"
                            value="{{ old('clock_in', optional($attendance?->clock_in)->format('H:i')) }}"
                            {{ $isPending ? 'disabled' : '' }}>

                        <span class="time-separator">～</span>

                        <input type="time" class="no-time-picker" name="clock_out"
                            value="{{ old('clock_out', optional($attendance?->clock_out)->format('H:i')) }}"
                            {{ $isPending ? 'disabled' : '' }}>

                        @error('clock_in')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                        @error('clock_out')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 休憩（複数） --}}
                @foreach($breaks as $i => $break)
                <tr>
                    <th>{{ $i === 0 ? '休憩' : '' }}</th>
                    <td>
                        <input
                            type="time"
                            class="no-time-picker"
                            name="breaks[{{ $i }}][start]"
                            value="{{ old("breaks.$i.start", optional($break->break_start)->format('H:i')) }}"
                            {{ $isPending ? 'disabled' : '' }}>

                        <span class="time-separator">～</span>

                        <input
                            type="time"
                            class="no-time-picker"
                            name="breaks[{{ $i }}][end]"
                            value="{{ old("breaks.$i.end", optional($break->break_end)->format('H:i')) }}"
                            {{ $isPending ? 'disabled' : '' }}>

                        {{-- 休憩「入り」エラー --}}
                        @error("breaks.$i.start")
                        <div class="field-error">{{ $message }}</div>
                        @enderror

                        {{-- 休憩「戻り」エラー --}}
                        @error("breaks.$i.end")
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                @endforeach

                {{-- 追加休憩（休憩２） --}}
                <tr>
                    <th>休憩２</th>
                    <td>
                        <input
                            type="time"
                            class="no-time-picker"
                            name="extra_break[start]"
                            value="{{ old('extra_break.start') }}"
                            {{ $isPending ? 'disabled' : '' }}>

                        <span class="time-separator">～</span>

                        <input
                            type="time"
                            class="no-time-picker"
                            name="extra_break[end]"
                            value="{{ old('extra_break.end') }}"
                            {{ $isPending ? 'disabled' : '' }}>

                        {{-- 休憩２「入り」エラー --}}
                        @error('extra_break.start')
                        <div class="field-error">{{ $message }}</div>
                        @enderror

                        {{-- 休憩２「戻り」エラー --}}
                        @error('extra_break.end')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 備考 --}}
                <tr>
                    <th>備考</th>
                    <td>
                        <textarea name="reason" rows="3" {{ $isPending ? 'disabled' : '' }}>{{ old('reason') }}</textarea>

                        @error('reason')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

            </tbody>
        </table>

        {{-- ボタン制御 --}}
        <div class="detail-footer">

            @if($isPending)
            <p class="pending-message">
                ＊ 承認待ちのため修正はできません。
            </p>
            @else

            {{-- 削除ボタン（勤怠があるときのみ） --}}
            @if($attendance)
            <button
                type="submit"
                name="action"
                value="delete"
                class="btn-delete {{ $isToday ? 'btn-disabled' : '' }}"
                {{ $isToday ? 'disabled' : '' }}>
                削除
            </button>
            @endif

            {{-- 修正ボタン --}}
            <button
                type="submit"
                name="action"
                value="edit"
                class="btn-edit {{ $isToday ? 'btn-disabled' : '' }}"
                {{ $isToday ? 'disabled' : '' }}>
                修正
            </button>

            @endif

        </div>

    </form>

</div>

@endsection