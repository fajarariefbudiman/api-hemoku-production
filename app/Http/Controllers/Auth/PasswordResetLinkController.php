<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordOtpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendOtp(ForgotPasswordOtpRequest $request)
    {
        $email = $request->input('email');
        $otp = mt_rand(100000, 999999);

        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        Mail::raw("Kode OTP Anda untuk reset kata sandi adalah: $otp", function ($message) use ($email) {
            $message->to($email)
                ->subject('Kode OTP Reset Password');
        });

        return response()->json([
            'message' => 'Kode OTP berhasil dikirim ke email Anda. Silakan cek kotak masuk.'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada data yang Anda kirimkan. Mohon periksa kembali.',
                'errors' => $validator->errors()
            ], 400);
        }

        $email = $request->input('email');
        $otpInput = $request->input('otp');

        $cachedOtp = Cache::get('otp_' . $email);

        if (!$cachedOtp) {
            return response()->json(['message' => 'Kode OTP tidak ditemukan atau telah kedaluwarsa.'], 404);
        }

        if ($otpInput != $cachedOtp) {
            return response()->json(['message' => 'Kode OTP tidak cocok.'], 404);
        }

        $tempToken = Str::random(40);
        Cache::put('otp_token_' . $tempToken, $email, now()->addMinutes(15));

        return response()->json([
            'message' => 'OTP berhasil diverifikasi.',
            'reset_token' => $tempToken
        ]);
    }
}
