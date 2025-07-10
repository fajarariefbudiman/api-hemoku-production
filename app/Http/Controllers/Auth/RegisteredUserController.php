<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'fullname' => $data['fullname'],
            'gender' => $data['gender'] ?? null,
            'email' => $data['email'],
            'birth_date' => $data['birth_date'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'id' => $user->id,
            'fullname' => $user->fullname,
            'gender' => $user->gender,
            'email' => $user->email,
            'birth_date' => optional($user->birth_date)->toDateString(),
            'phone_number' => $user->phone_number,
            'created_at' => $user->created_at->toISOString(),
            'updated_at' => $user->updated_at->toISOString(),
            'health_progress' => [
                'last_screening_date' => null,
                'status' => null,
                'suggestion' => null
            ],
            'medication_status' => [
                'last_taken_time' => null,
                'consecutive_progress' => null,
                'alarm_notification' => null
            ]
        ], 201);
    }
}
