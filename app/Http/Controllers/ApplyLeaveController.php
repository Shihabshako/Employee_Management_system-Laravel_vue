<?php

namespace App\Http\Controllers;

use App\Events\NotificationPublished;
use App\Mail\InformAdministration;
use App\Models\ApplyLeave;
use App\Models\User;
use App\Notifications\ApplyLeave as NotificationsApplyLeave;
use App\Notifications\NotifyAdministration;
use App\Notifications\NotifyApplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

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

            $manager = User::where("id", $user->manager_id)->first();
            //notifying manager
            Notification::send($manager, new NotificationsApplyLeave($user->name, $applyLeave->id));


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
            $applyLeave = DB::table('apply_leaves')->join("users", "apply_leaves.user_id", "=", "users.id")->select("apply_leaves.*", "users.name", "type_of_leaves.title")->where("apply_leaves.id", $id)->join("type_of_leaves", "apply_leaves.type_of_leave_id", "=", "type_of_leaves.id")->first();
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

    public function approveApplicationByManager($id)
    {
        try {
            $application = ApplyLeave::query()->whereId($id)->first();
            if ($application) {
                $application->update([
                    "approved_by_manager" => 1
                ]);

                $administration = User::all()->filter(function ($user) {
                    if ($user->role_id != 3) {
                        return $user;
                    }
                });
                $user = User::whereId($application->user_id)->first();

                //notify administration 
                Notification::send($administration, new NotifyAdministration($user->name, $application->id));

                //mail to admin
                Mail::to($administration)->send(new InformAdministration($user->name, 'approved', $application->id));



                return sendSuccessResponse($application, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function declineApplicationByManager($id)
    {
        try {
            $application = ApplyLeave::query()->whereId($id)->first();
            if ($application) {
                $application->update([
                    "approved_by_manager" => 3
                ]);
                return sendSuccessResponse($application, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function approveApplicationByAdministration($id)
    {
        try {
            $application = ApplyLeave::query()->whereId($id)->first();
            if ($application) {
                $application->update([
                    "approved_by_administration" => 1
                ]);

                $user = User::whereId($application->user_id)->first();

                //notify users 
                Notification::send($user, new NotifyApplier('', $application->id, 'Application Approved'));

                return sendSuccessResponse($application, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function declineApplicationByAdministration($id)
    {
        try {
            $application = ApplyLeave::query()->whereId($id)->first();
            if ($application) {
                $application->update([
                    "approved_by_administration" => 3
                ]);

                $user = User::whereId($application->user_id)->first();

                //notify user 
                Notification::send($user, new NotifyApplier('', $application->id, 'Application Approved'));

                return sendSuccessResponse($application, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }
}
