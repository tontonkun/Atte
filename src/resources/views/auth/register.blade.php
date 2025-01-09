@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}"> <!-- ログインページ専用CSS -->
@endsection

@section('content')

<div class="content">
    <form class="form" action="register" method="POST">
        @csrf
        <div class="titleArea">
            <div class="title">
                会員登録
            </div>
        </div>

        <div class="inputArea">
            <input class="name" type="text" name="name" placeholder="名前" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="inputArea">
            <input class="mail" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="inputArea">
            <input class="password" type="password" name="password" placeholder="パスワード">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="inputArea">
            <input class="password" type="password" name="password_confirmation" placeholder="確認用パスワード">
        </div>

        <div class="buttonArea">
            <button class="registerButton" type="submit">会員登録</button>
        </div>

        <div class="annonceForMenbers">
            <div>
                アカウントをお持ちの方はこちらから
            </div>

            <a href="login" class="loginLink">
                ログイン
            </a>
        </div>
    </form>
    @endsection