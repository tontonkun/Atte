@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}"> <!-- ログインページ専用CSS -->
@endsection

@section('content')
<form class="form" action="/login" method="post">
    @csrf
    <div class="titleArea">
        <div class="title">
            ログイン
        </div>
    </div>

    <div class="inputArea">
        <input class="mail" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" />
    </div>
    <div class="form__error">
        @error('email')
            {{ $message }}
        @enderror
    </div>

    <div class="inputArea">
        <input class="password" type="password" name="password" placeholder="パスワード" />
    </div>
    <div class="form__error">
        @error('password')
            {{ $message }}
        @enderror
    </div>

    <div class="buttonArea">
        <button class="loginButton" type="submit">ログイン</button>
    </div>

    <div class="annonceForNoAccount">
        <div>
            アカウントをお持ちでない方はこちらから
        </div>

        <a href="register" class="registerLink">
            会員登録
        </a>
    </div>
</form>
@endsection