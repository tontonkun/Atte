@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/time_record.css') }}">
@endsection

@section('headerLinks')
<div class="headerLinks">
    <form class="form" action="/" method="GET">
        @csrf
        <button class="header-nav__button">ホーム</button>
    </form>
    <form class="form" action="/time_record" method="GET">
        @csrf
        <button class="header-nav__button">日付一覧</button>
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

    <form action="/time_record_yesterday" method="GET">
        @csrf
        <input type="hidden" name="date" value="{{ $work_date }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <button class="yesterday">＜</button>
    </form>

    <div class="title">{{ $user->name }} の勤怠情報 - {{ $work_date }}</div>

    <form action="/time_record_tomorrow" method="GET">
        @csrf
        <input type="hidden" name="date" value="{{ $work_date }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <button class="tomorrow">＞</button>
    </form>

</div>

<table class="timeRecord">
    <tr>
        <th>日付</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
    </tr>
    @foreach ($works as $work)
        <tr>
            <td>{{ $work->work_date }}</td>
            <td>{{ $work->start_at }}</td>
            <td>{{ $work->end_at }}</td>
            <td>{{ $work->formatted_duration }}</td>
            <td>{{ $work->total_work_duration }}</td>
        </tr>
    @endforeach
</table>
</div>
<div class="pagination">
    {{ $works->links() }} <!-- カスタムビューを指定 -->
    @endsection