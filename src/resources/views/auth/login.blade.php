@extends('layouts.app_login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="auth-container">

  <h2>ログイン</h2>
  <form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    {{-- メールアドレス --}}
    <div class="form-group">
      <label for="email">メールアドレス</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}">
      @error('email')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

    {{-- パスワード --}}
    <div class="form-group">
      <label for="email">パスワード</label>
      <input id="password" type="password" name="password">
      @error('password')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit">ログインする</button>
  </form>

  <a href="{{ route('register') }}">会員登録はこちら</a>
</div>
@endsection