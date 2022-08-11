<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function notificationPerUser($id)
    {
        try {
            $notifications = DB::table('notifications')->where("notifiable_id", $id)->get();
            if ($notifications) {
                return sendSuccessResponse($notifications, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function notificationMarkRead($id)
    {
        try {
            $notifications = DB::table('notifications')->where("notifiable_id", $id)->update(["read_at" => Carbon::now()->toDateTimeString()]);
            $notifications = DB::table('notifications')->where("notifiable_id", $id)->get();
            if ($notifications) {
                return sendSuccessResponse($notifications, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Database error', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }
}
