<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeRecordController extends Controller
{
   private $totalDuration = 0;

   public function timeRecord()
   {
      $userId = auth()->id();
      $user = User::findOrFail($userId);
      $work_date = Carbon::today()->toDateString();

      $works = $this->getWorks($userId, $work_date);

      $this->calculateDurations($works);

      return view('time_record', compact('work_date', 'works', 'user'));
   }

   public function yesterday(Request $request)
   {
      $work_date = Carbon::parse($request->date)->subDay()->format('Y-m-d');
      $user = User::findOrFail($request->user_id);

      $works = $this->getWorks($request->user_id, $work_date);

      $this->calculateDurations($works);

      return view('time_record', compact('works', 'work_date', 'user'));
   }

   public function tomorrow(Request $request)
   {
      $work_date = Carbon::parse($request->date)->addDay()->format('Y-m-d');
      $user = User::findOrFail($request->user_id);

      $works = $this->getWorks($request->user_id, $work_date);

      $this->calculateDurations($works);

      return view('time_record', compact('works', 'work_date', 'user'));
   }

   private function getWorks($userId, $work_date)
   {
      return Work::where('user_id', $userId)
         ->whereDate('work_date', $work_date)
         ->with(['rests'])
         ->paginate(5)
         ->appends(['date' => $work_date, 'user_id' => $userId]);
   }

   private function calculateDurations($works)
   {
      foreach ($works as $work) {
         if ($work->start_at && $work->end_at) {
            $start = Carbon::parse($work->start_at);
            $end = Carbon::parse($work->end_at);
            $duration = $end->diffInSeconds($start);
            $this->totalDuration += $duration;

            $breakDuration = 0;

            foreach ($work->rests as $rest) {
               if ($rest->break_start_time && $rest->break_end_time) {
                  $breakStart = Carbon::parse($rest->break_start_time);
                  $breakEnd = Carbon::parse($rest->break_end_time);
                  $breakDuration += $breakEnd->diffInSeconds($breakStart);
               }
            }

            $totalWorkDuration = $duration - $breakDuration;
            $work->total_work_duration = $this->formatDuration($totalWorkDuration);
            $work->break_duration = $this->formatDuration($breakDuration); // 追加
         } else {
            $work->total_work_duration = '勤務中';
            $work->break_duration = '休憩中'; // 追加
         }
      }
   }

   private function formatDuration($seconds)
   {
      $hours = floor($seconds / 3600);
      $minutes = floor(($seconds % 3600) / 60);
      $remainingSeconds = $seconds % 60;

      return sprintf('%d:%02d:%02d', $hours, $minutes, $remainingSeconds);
   }

   public function timeRecord_forOneUser(Request $request)
   {
      $user = User::findOrFail($request->user_id);
      $work_date = $request->date ?? now()->format('Y-m-d');

      $works = Work::where('user_id', $user->id)
         ->whereDate('work_date', $work_date)
         ->paginate(5)
         ->appends(['date' => $work_date, 'user_id' => $user->id]);

      $this->calculateDurations($works);

      return view('time_record', compact('work_date', 'works', 'user'));
   }
}
