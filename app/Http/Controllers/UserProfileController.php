<?php

namespace App\Http\Controllers;

use App\Models\ReminderLog;
use App\Models\ScreeningSessions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    //
    public function show()
    {
        $user = Auth::user();

        $latestScreening = ScreeningSessions::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $lastTakenLog = ReminderLog::where('user_id', $user->id)
            ->where('is_taken', true)
            ->latest('date')
            ->first();

        $consecutiveDays = 0;
        $date = Carbon::today();

        while (ReminderLog::where('user_id', $user->id)
            ->whereDate('date', $date)
            ->where('is_taken', true)
            ->exists()
        ) {
            $consecutiveDays++;
            $date->subDay();
        }

        return response()->json([
            'id' => $user->id,
            'fullname' => $user->fullname,
            'gender' => $user->gender,
            'email' => $user->email,
            'birth_date' => $user->birth_date,
            'phone_number' => $user->phone_number,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'health_progress' => [
                'last_screening_date' => $latestScreening?->created_at?->toDateString(),
                'status' => $latestScreening?->risk_level,
                'suggestion' => $latestScreening?->risk_description,
            ],
            'medication_status' => [
                'last_taken_time' => $lastTakenLog ? Carbon::parse($lastTakenLog->date)->diffForHumans() : null,
                'consecutive_progress' => $consecutiveDays > 0 ? "{$consecutiveDays} Hari berurut" : null,
            ]
        ]);
    }
}
