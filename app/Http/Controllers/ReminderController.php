<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reminders = Reminder::where('user_id', Auth::id())->get();

        return response()->json($reminders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'is_menstruating' => 'required|boolean',
        ]);

        $today = now();
        $dayOfWeek = $today->format('l');

        $exists = Reminder::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Reminder hari ini sudah ada.'], 200);
        }

        if ($user->gender === 'female') {
            if ($request->is_menstruating) {
                Reminder::create([
                    'user_id' => $user->id,
                    'time' => '08:00:00',
                    'day_of_week' => $dayOfWeek,
                    'is_menstruating' => true,
                    'category' => 'anemia',
                ]);
            } else {
                $exists = Reminder::where('user_id', $user->id)
                    ->where('is_menstruating', false)
                    ->whereDate('created_at', '>=', $today->copy()->subDays(6))
                    ->exists();

                if (!$exists) {
                    Reminder::create([
                        'user_id' => $user->id,
                        'time' => '08:00:00',
                        'day_of_week' => $dayOfWeek,
                        'is_menstruating' => false,
                        'category' => 'anemia',
                    ]);
                }
            }

        } elseif ($user->gender === 'male') {
            $exists = Reminder::where('user_id', $user->id)
                ->whereDate('created_at', '>=', $today->copy()->subDays(6))
                ->exists();

            if (!$exists) {
                Reminder::create([
                    'user_id' => $user->id,
                    'time' => '08:00:00',
                    'day_of_week' => $dayOfWeek,
                    'is_menstruating' => false,
                    'category' => 'anemia',
                ]);
            }
        }

        return response()->json(['message' => 'Reminder berhasil dibuat.'], 201);
    }

}
