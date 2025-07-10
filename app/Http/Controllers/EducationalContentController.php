<?php

namespace App\Http\Controllers;

use App\Models\EducationalContent;
use App\Http\Requests\StoreEducationalContentRequest;
use App\Http\Requests\UpdateEducationalContentRequest;
use Illuminate\Http\Request;

class EducationalContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EducationalContent::query();

        if ($request->has('section')) {
            $query->where('section', $request->section);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->orderBy('order')->get());
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
    public function store(StoreEducationalContentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationalContent $educationalContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationalContent $educationalContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationalContentRequest $request, EducationalContent $educationalContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationalContent $educationalContent)
    {
        //
    }
}
