@extends('layouts.app_login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="auth-container">
  <h1>会員登録</h1>
  <form method="POST" action="{{ route('register') }}" novalidate>
    @csrf

    {{-- ユーザー名 --}}
    <div class="form-group">
      <label for="name">名前</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}">
      @error('name')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

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
      <label for="password">パスワード</label>
      <input id="password" type="password" name="password">
      @error('password')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

    {{-- 確認用パスワード --}}
    <div class="form-group">
      <label for="password_confirmation">パスワード確認</label>
      <input id="password_confirmation" type="password" name="password_confirmation">
      @error('password_confirmation')
      <div class="error">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit">登録する</button>
  </form>

  <a href="{{ route('login') }}">ログインはこちら</a>
</div>
@endsection