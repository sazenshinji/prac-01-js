<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>勤怠管理アプリ</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>
  <meta name="stripe-key" content="{{ config('services.stripe.key') }}">

  @yield('css')
</head>

<body>
  <header class="header">

    <div class="logo">
      <a href="{{ url('/attendance') }}">
        <img class="logo-img" src="{{ asset('images/Coachtech.jpg') }}" alt="勤怠">
      </a>
    </div>

    <nav class="nav-menu">
      <ul>
        <li><a href="{{ url('/attendance') }}">勤怠</a></li>
        <li><a href="{{ url('/attendance/list') }}">勤怠一覧</a></li>

        {{-- ★ 申請一覧へ遷移するリンクに変更 --}}
        <li><a href="{{ route('request.list') }}">申請</a></li>

        {{-- ログアウトフォーム --}}
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">ログアウト</button>
          </form>
        </li>
      </ul>
    </nav>

  </header>

  <main class="content">
    @yield('content')
  </main>
</body>

</html>