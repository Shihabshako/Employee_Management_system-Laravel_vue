<?php

namespace App\Http\Controllers;

use App\Events\NotificationPublished;
use App\Models\ApplyLeave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use App\Events\NotificationPublished;

class ApplyLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $applyLeave = DB::table('apply_leaves')->join("users", "apply_leaves.user_id", "=", "users.id")->select("apply_leaves.*", "users.name", "users.email")->get();
            if ($applyLeave) {
                return sendSuccessResponse($applyLeave, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
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

            event(new NotificationPublished("shihab jamil"));

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
    public function show($id)
    {
        try {
            $applyLeave = DB::table('apply_leaves')->join("users", "apply_leaves.user_id", "=", "users.id")->select("apply_leaves.*", "users.name")->where("apply_leaves.id", $id)->first();
            if ($applyLeave) {
                return sendSuccessResponse($applyLeave, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
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

    public function applicationPerManager(Request $request)
    {
        try {
            $managerId = User::where("email", $request->email)->first();
            $managerId = $managerId->id;
            $applyLeave = DB::table('users')->select("apply_leaves.*", "us2.name")->where("users.manager_id", $managerId)->join('apply_leaves', 'users.id', '=', 'apply_leaves.user_id')->join("users AS us2", "apply_leaves.user_id", "=", "us2.id")->get();
            if ($applyLeave) {
                return sendSuccessResponse($applyLeave, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function approveApplicationByManager(Request $request)
    {
        try {
            $application = ApplyLeave::query()->whereId($request->id)->first();
            if ($application) {
                $application->update([
                    "approved_by_manager" => 1
                ]);
                return sendSuccessResponse($application, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }
}
