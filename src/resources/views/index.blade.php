@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('headerLinks')
<div class="headerLinks">
    <form class="form" action="/" method="GET">
        @csrf
        <button class="header-nav__button">ホーム</button>
    </form>
    <form class="form" action="/time_record" method="GET">
        @csrf
        <button class="header-nav__button">勤怠一覧</button>
    </form>
    <form class="form" action="/user_list" method="GET">
        @csrf
        <button class="header-nav__button">ユーザー一覧</button>
    </form>
    <form class="form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="header-nav__button">ログアウト</button>
    </form>
</div>
@endsection

@section('content')

<div class="titleArea">
    <div class="title">
        @if ($workStartDisabled && $workEndDisabled && $restStartDisabled && $restEndDisabled)
            {{ $userName }}さん 今日の勤務は終了しています　<br>お疲れ様でした！
        @else
            {{ $userName }}さん　お疲れ様です！
        @endif
    </div>
</div>

<div class="buttonArea">
    <form class="form" action="/start_work" method="POST">
        @csrf
        <button id="startWorkButton" class="workStart" type="submit" {{ $workStartDisabled ? 'disabled' : '' }}>勤務開始</button>
    </form>

    <form class="form" action="/end_work" method="POST">
        @csrf
        <button id="endWorkButton" class="workEnd" type="submit" {{ $workEndDisabled ? 'disabled' : '' }}>勤務終了</button>
    </form>
</div>

<div class="buttonArea">
    <form class="form" action="/start_rest" method="POST">
        @csrf
        <button id="startRestButton" class="restStart" type="submit" {{ $restStartDisabled ? 'disabled' : '' }}>休憩開始</button>
    </form>

    <form class="form" action="/end_rest" method="POST">
        @csrf
        <button id="endRestButton" class="restEnd" type="submit" {{ $restEndDisabled ? 'disabled' : '' }}>休憩終了</button>
    </form>
</div>
@endsection