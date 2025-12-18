@php
$layout = auth()->user()->role === 1
? 'layouts.app_admin'
: 'layouts.app';
@endphp

@extends($layout)

@section('css')
<link rel="stylesheet" href="{{ asset('css/request.css') }}">
@endsection

@section('content')
<div class="attendance-list-wrapper">

    <h1 class="page-title">
        申請一覧
    </h1>

    {{-- タブ切り替え --}}
    <div class="request-tab-nav">
        <a href="{{ route('request.list', ['tab' => 'pending']) }}"
            class="request-tab-btn {{ $tab === 'pending' ? 'is-active' : '' }}">
            承認待ち
        </a>

        <a href="{{ route('request.list', ['tab' => 'approved']) }}"
            class="request-tab-btn {{ $tab === 'approved' ? 'is-active' : '' }}">
            承認済み
        </a>
    </div>

    {{-- タブ下の横線 --}}
    <hr class="request-tab-border">

    @php
    $list = $tab === 'approved' ? $approved : $pending;
    $statusLabel = $tab === 'approved' ? '承認済み' : '承認待ち';
    @endphp

    <table class="attendance-table">
        <thead>
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $correction)
            @php
            $after = $correction->afterCorrection;
            @endphp
            <tr>
                {{-- 状態 --}}
                <td>{{ $statusLabel }}</td>

                {{-- 名前 --}}
                <td>
                    @if($isAdmin)
                    {{ $correction->targetUser->name }}
                    @else
                    {{ $user->name }}
                    @endif
                </td>

                {{-- 対象日時（after_corrections.after_work_date） --}}
                <td>
                    @if($after && $after->after_work_date)
                    {{ \Carbon\Carbon::parse($after->after_work_date)->format('Y/m/d') }}
                    @endif
                </td>

                {{-- 申請理由 --}}
                <td>{{ $correction->reason }}</td>

                {{-- 申請日時（corrections.created_at） --}}
                <td>
                    {{ $correction->created_at
                            ? $correction->created_at->format('Y/m/d')
                            : '' }}
                </td>

                {{-- 詳細ボタン（処理は後で実装） --}}
                <td>
                    <a href="{{ route('request.detail', ['id' => $correction->id]) }}{{ $tab === 'approved' ? '?tab=approved' : '' }}">
                        <button class="btn-detail">詳細</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    申請はありません。
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection