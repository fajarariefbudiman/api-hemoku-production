<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\ForgotPasswordOtpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Kredensial tidak valid.'
            ], 401);
        }

        $user = Auth::user();
        $token = $request->user()->createToken('auth_token');


        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Tidak sah. Anda belum login atau token tidak valid.'
            ], 401);
        }

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout. Sesi Anda telah diakhiri.'
        ], 200);
    }

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

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
            'reset_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 400);
        }

        $token = $request->reset_token;
        $email = Cache::get('otp_token_' . $token);

        if (!$email || !Cache::get('otp_' . $email)) {
            return response()->json([
                'message' => 'Token tidak valid atau OTP belum diverifikasi.'
            ], 403);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Pengguna tidak ditemukan.'
            ], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Cache::forget('otp_' . $email);
        Cache::forget('otp_token_' . $token);

        return response()->json(['message' => 'Kata sandi berhasil direset.']);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi tidak cocok dengan kata sandi baru.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada data yang Anda kirimkan. Mohon periksa kembali.',
                'errors' => $validator->errors()
            ], 400);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Kata sandi lama yang Anda masukkan tidak cocok.'
            ], 400);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Kata sandi berhasil diubah. Silakan gunakan kata sandi baru Anda untuk login berikutnya.'
        ]);
    }

    public function deleteAccount()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Tidak sah. Anda perlu login untuk menghapus akun.'
            ], 401);
        }

        if ($user instanceof \Illuminate\Database\Eloquent\Collection) {
            $user = $user->first();
        }
        try {
            $user->delete();

            return response()->json([
                'message' => 'Akun Anda berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus akun. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}
