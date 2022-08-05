<?php

namespace App\Http\Controllers;

use App\Models\TypeOfLeave;
use Illuminate\Http\Request;

class TypeOfLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $typeOfLeave = TypeOfLeave::all();
            if ($typeOfLeave) {
                return sendSuccessResponse($typeOfLeave, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Email and password does not match with our records', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeOfLeave  $typeOfLeave
     * @return \Illuminate\Http\Response
     */
    public function show(TypeOfLeave $typeOfLeave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeOfLeave  $typeOfLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeOfLeave $typeOfLeave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeOfLeave  $typeOfLeave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeOfLeave $typeOfLeave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeOfLeave  $typeOfLeave
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeOfLeave $typeOfLeave)
    {
        //
    }
}
