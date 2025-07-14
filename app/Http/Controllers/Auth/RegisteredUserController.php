<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();
            $phone = str_replace(' ', '', $data['phone_number']);

            $user = User::create([
                'fullname'      => $data['fullname'],
                'gender'        => $data['gender'],
                'email'         => $data['email'],
                'birth_date'    => $data['birth_date'],
                'phone_number'  => $phone,
                'password'      => Hash::make($data['password']),
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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada data yang Anda kirimkan. Mohon periksa kembali.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses permintaan Anda.',
                'errors' => [
                    'general' => [$e->getMessage()]
                ]
            ], 400);
        }
    }
}
