<?php

namespace App\Http\Controllers;

use App\Models\ReminderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = ReminderLog::where('user_id', Auth::id())->get();

        return response()->json($logs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'date' => 'required|date',
            'is_taken' => 'required|boolean',
            'is_menstruating' => 'required|boolean',
            'category' => 'nullable|string'
        ]);

        $exists = ReminderLog::where('user_id', $user->id)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Log pada tanggal ini sudah tercatat.'
            ], 200);
        }

        $log = ReminderLog::create([
            'user_id' => $user->id,
            'date' => $request->date,
            'is_taken' => $request->is_taken,
            'is_menstruating' => $request->is_menstruating,
            'category' => $request->category ?? 'anemia',
        ]);

        return response()->json($log, 201);
    }

}
