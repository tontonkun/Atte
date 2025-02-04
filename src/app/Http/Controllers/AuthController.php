<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function firstHomePage()
    {
        $userId = auth()->id();
        $currentDate = now()->format('Y-m-d');

        // 今日の作業を取得
        $currentWork = Work::where('user_id', $userId)
            ->where('work_date', $currentDate)
            ->whereNull('end_at') // まだ終了していない作業を確認
            ->first();

        // 今日の休憩を取得
        $currentRest = Rest::where('work_id', $currentWork->id ?? null)
            ->whereNull('break_end_time') // まだ終了していない休憩を確認
            ->first();

        // セッションからボタンの状態を取得
        $workStartDisabled = Session::get('workStartDisabled', !is_null($currentWork));
        $workEndDisabled = Session::get('workEndDisabled', is_null($currentWork));
        $restStartDisabled = Session::get('restStartDisabled', is_null($currentWork) || !is_null($currentRest));
        $restEndDisabled = Session::get('restEndDisabled', is_null($currentRest));

        $userName = Auth::user()->name;

        return view('index', compact('workStartDisabled', 'workEndDisabled', 'restStartDisabled', 'restEndDisabled', 'userName'));
    }

    public function afterStartWork(Request $request)
    {
        $userId = auth()->id();
        $userName = Auth::user()->name;
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');

        Work::create([
            'user_id' => $userId,
            'work_date' => $currentDate,
            'start_at' => $currentTime,
        ]);

        // セッションに状態を保存
        Session::put('workStartDisabled', true);
        Session::put('workEndDisabled', false);
        Session::put('restStartDisabled', false);
        Session::put('restEndDisabled', true);

        // 状態を更新してビューを返す
        $workStartDisabled = true;
        $workEndDisabled = false;
        $restStartDisabled = false;
        $restEndDisabled = true;

        return view('index', compact('workStartDisabled', 'workEndDisabled', 'restStartDisabled', 'restEndDisabled', 'userName'));
    }

    public function afterEndWork(Request $request)
    {
        $userId = auth()->id();
        $userName = Auth::user()->name;
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');

        $currentWork = Work::where('user_id', $userId)
            ->where('work_date', $currentDate)
            ->whereNull('end_at')
            ->first();

        if ($currentWork) {
            $currentWork->end_at = $currentTime;
            $currentWork->save();
        } else {
            return redirect()->back()->withErrors('現在の作業が見つかりません。');
        }

        // セッションから前回の更新日を取得
        $previousDate = Session::get('previousDate', $currentDate);

        // 日付が変わったかどうかをチェック
        if ($previousDate !== $currentDate) {
            // 日付が変わった場合にセッション状態を更新
            Session::put('workStartDisabled', false);
            Session::put('workEndDisabled', true);
            Session::put('restStartDisabled', true);
            Session::put('restEndDisabled', true);

            // 更新された日付をセッションに保存
            Session::put('previousDate', $currentDate);
        } else {
            // 日付が変わらない場合はすべてをtrueに設定
            Session::put('workStartDisabled', true);
            Session::put('workEndDisabled', true);
            Session::put('restStartDisabled', true);
            Session::put('restEndDisabled', true);
        }

        // 状態を更新してビューを返す
        $workStartDisabled = Session::get('workStartDisabled');
        $workEndDisabled = Session::get('workEndDisabled');
        $restStartDisabled = Session::get('restStartDisabled');
        $restEndDisabled = Session::get('restEndDisabled');

        return view('index', compact('workStartDisabled', 'workEndDisabled', 'restStartDisabled', 'restEndDisabled', 'userName'));
    }
    
    public function afterStartRest(Request $request)
    {
        $userId = auth()->id();
        $userName = Auth::user()->name;
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');

        $work = Work::where('user_id', $userId)
            ->where('work_date', $currentDate)
            ->first();

        if ($work) {
            Rest::create([
                'work_id' => $work->id,
                'break_start_time' => $currentTime,
            ]);
        } else {
            return redirect()->back()->withErrors(['message' => '作業データが見つかりません。先に作業を登録してください。']);
        }

        // セッションに状態を保存
        Session::put('workEndDisabled', true);
        Session::put('restStartDisabled', true);
        Session::put('restEndDisabled', false);

        // 状態を更新してビューを返す
        $workStartDisabled = true;
        $workEndDisabled = true;
        $restStartDisabled = true;
        $restEndDisabled = false;

        return view('index', compact('workStartDisabled', 'workEndDisabled', 'restStartDisabled', 'restEndDisabled', 'userName'));
    }

    public function afterEndRest(Request $request)
    {
        $userId = auth()->id();
        $userName = Auth::user()->name;
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');

        $work = Work::where('user_id', $userId)
            ->where('work_date', $currentDate)
            ->first();

        if ($work) {
            $rest = Rest::where('work_id', $work->id)
                ->whereNull('break_end_time')
                ->first();

            if ($rest) {
                $rest->break_end_time = $currentTime;
                $rest->save();
            } else {
                return redirect()->back()->withErrors(['message' => '現在の休憩データが見つかりません。']);
            }
        } else {
            return redirect()->back()->withErrors(['message' => '作業データが見つかりません。先に作業を登録してください。']);
        }

        // セッションに状態を保存
        Session::put('restStartDisabled', false);
        Session::put('restEndDisabled', true);

        // 状態を更新してビューを返す
        $workStartDisabled = true;
        $workEndDisabled = false;
        $restStartDisabled = false;
        $restEndDisabled = true;

        return view('index', compact('workStartDisabled', 'workEndDisabled', 'restStartDisabled', 'restEndDisabled', 'userName'));
    }
}
