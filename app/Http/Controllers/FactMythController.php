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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFactMythRequest $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FactMyth $factMyth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFactMythRequest $request, FactMyth $factMyth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FactMyth $factMyth)
    {
        //
    }
}
