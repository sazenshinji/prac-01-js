<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>フリマアプリ</title>
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
      <a href="{{ url('/') }}">
        <img class="logo-img" src="{{ asset('images/Coachtech.jpg') }}" alt="フリマ">
      </a>
    </div>

  </header>

  <main class="content">
    @yield('content')
  </main>
</body>

</html>