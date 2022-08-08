<?php

namespace App\Http\Controllers;

use App\Models\ApplyLeave;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NotificationPublished;

class ApplyLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        try {
            $user = User::where("email", "=", $request->userEmail)->first();
            $applyLeave = ApplyLeave::create([
                "user_id" => $user->id,
                "type_of_leave_id" => $request->typeOfLeaves,
                "subject" => $request->subject,
                "from" => $request->from,
                "to" => $request->to,
                "details" => $request->details,
            ]);

            event(new NotificationPublished($user->name));

            return sendSuccessResponse($applyLeave, 'Data stored successfully', 200);
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplyLeave  $applyLeave
     * @return \Illuminate\Http\Response
     */
    public function show(ApplyLeave $applyLeave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplyLeave  $applyLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplyLeave $applyLeave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplyLeave  $applyLeave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplyLeave $applyLeave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplyLeave  $applyLeave
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplyLeave $applyLeave)
    {
        //
    }
}
