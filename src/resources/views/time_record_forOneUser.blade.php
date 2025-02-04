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
    <div class="title">{{ $user->name }} の勤怠情報 - {{ $work_date }}</div>
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
            <td>{{ $work->break_duration }}</td> <!-- 各勤務ごとの休憩時間を表示 -->
            <td>{{ $work->total_work_duration }}</td> <!-- 実際の勤務時間 -->
        </tr>
    @endforeach
</table>

<div class="pagination">
    {{ $works->appends(['date' => $work_date, 'user_id' => $user->id])->links() }}
</div>

@endsection