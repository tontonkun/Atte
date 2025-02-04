<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeRecordController extends Controller
{
   private $totalDuration = 0;

   // すべてのユーザーの勤務情報を取得
   public function timeRecord()
   {
      // 全ユーザーの勤務データを取得
      $work_date = Carbon::today()->toDateString();

      // ユーザーごとの勤務データを取得して結合
      $works = Work::with('user', 'rests')
         ->whereDate('work_date', $work_date)
         ->paginate(5)  // ページネーションを適用
         ->appends(['date' => $work_date]);

      $this->calculateDurations($works);

      return view('time_record', compact('work_date', 'works'));
   }

   public function yesterday(Request $request)
   {
      // 昨日の勤務データを取得
      $work_date = Carbon::parse($request->date)->subDay()->format('Y-m-d');

      // ユーザーごとの勤務データを取得して結合
      $works = Work::with('user', 'rests')
         ->whereDate('work_date', $work_date)
         ->paginate(5)  // ページネーションを適用
         ->appends(['date' => $work_date]);

      $this->calculateDurations($works);

      return view('time_record', compact('work_date', 'works'));
   }

   public function tomorrow(Request $request)
   {
      // 明日の勤務データを取得
      $work_date = Carbon::parse($request->date)->addDay()->format('Y-m-d');

      // ユーザーごとの勤務データを取得して結合
      $works = Work::with('user', 'rests')
         ->whereDate('work_date', $work_date)
         ->paginate(5)  // ページネーションを適用
         ->appends(['date' => $work_date]);

      $this->calculateDurations($works);

      return view('time_record', compact('work_date', 'works'));
   }

   // 勤務情報を取得
   private function getWorks($userId, $work_date)
   {
      return Work::where('user_id', $userId)
         ->whereDate('work_date', $work_date)
         ->with(['rests'])
         ->paginate(5)
         ->appends(['date' => $work_date, 'user_id' => $userId]);
   }

   // 勤務時間と休憩時間を計算
   private function calculateDurations($works)
   {
      foreach ($works as $work) {
         if ($work->start_at && $work->end_at) {
            $start = Carbon::parse($work->start_at);
            $end = Carbon::parse($work->end_at);
            $duration = $end->diffInSeconds($start);

            $breakDuration = 0;
            foreach ($work->rests as $rest) {
               if ($rest->break_start_time && $rest->break_end_time) {
                  $breakStart = Carbon::parse($rest->break_start_time);
                  $breakEnd = Carbon::parse($rest->break_end_time);
                  $breakDuration += $breakEnd->diffInSeconds($breakStart);
               }
            }

            // 実働時間と休憩時間を計算
            $totalWorkDuration = $duration - $breakDuration;
            $work->total_work_duration = $this->formatDuration($totalWorkDuration);
            $work->break_duration = $this->formatDuration($breakDuration);
         } else {
            $work->total_work_duration = '勤務中';
            $work->break_duration = '休憩中';
         }
      }
   }

   // 秒数を時間形式に変換
   private function formatDuration($seconds)
   {
      $hours = floor($seconds / 3600);
      $minutes = floor(($seconds % 3600) / 60);
      $remainingSeconds = $seconds % 60;

      return sprintf('%d:%02d:%02d', $hours, $minutes, $remainingSeconds);
   }
}
