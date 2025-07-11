<?php

namespace App\Http\Controllers;

use App\Models\FactMyth;
use App\Http\Requests\StoreFactMythRequest;
use App\Http\Requests\UpdateFactMythRequest;
use Illuminate\Support\Facades\Auth;

class FactMythController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Anda perlu login untuk mengakses ini.'
            ], 401);
        }

        $factMyths = FactMyth::all();

        return response()->json([
            'message' => 'Daftar fakta dan mitos berhasil diambil.',
            'data' => $factMyths
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $factMyth = FactMyth::find($id);

        if (!$factMyth) {
            return response()->json([
                'message' => 'Fakta/mitos tidak ditemukan dengan ID tersebut.'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail fakta/mitos berhasil ditemukan.',
            'data' => $factMyth
        ], 200);
    }

}
