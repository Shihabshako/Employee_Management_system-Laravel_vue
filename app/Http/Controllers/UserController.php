<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\UserSocialProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function destroy($id)
    {
        try {
            $user = User::whereId($id)->first();
            if ($user) {
                $user_social_profile = UserSocialProfile::where('user_id', $id)->first();
                $user_social_profile->delete();
                $user->delete();
                return sendSuccessResponse([], 'Data deleted successfully');
            } else {
                return sendErrorResponse('Invalid ID', [], 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database not found!', $e->getMessage(), 500);
        }
    }

    public function userDetailsShow(Request $request)
    {
        try {
            $user = DB::table('users')->join('departments', 'users.dept_id', '=', 'departments.id')->join('designations', 'users.designation_id', '=', 'designations.id')->leftJoin("users AS usm", "users.manager_id", "=", "usm.id")->join("user_social_profiles", "user_social_profiles.user_id", "=", "users.id")->select("users.*", "departments.dept_name", "designations.title AS designation", "usm.name AS manager", "user_social_profiles.website", "user_social_profiles.github", "user_social_profiles.twitter", "user_social_profiles.linkedin", "user_social_profiles.facebook", "users.role_id AS role", "users.dept_id AS department", "users.designation_id AS designation_name")->where("users.email", $request->email)->first();
            if ($user) {
                return sendSuccessResponse($user, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Email and password does not match with our records', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function updateUser(Request $request, $id)
    {

        try {
            $user = User::whereId($id)->first();
            $website = UserSocialProfile::where("user_id", $id)->first();
            if ($user) {
                $user->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "address" => $request->address

                ]);

                if ($request->role_id != 0 || $request->role_id != Null) {
                    $user->update([
                        "role_id" => $request->role_id
                    ]);
                }
                if ($request->designation_id != 0 || $request->designation_id != Null) {
                    $user->update([
                        "designation_id" => $request->designation_id
                    ]);
                }
                if ($request->dept_id != 0 || $request->dept_id != Null) {
                    $user->update([
                        "dept_id" => $request->dept_id
                    ]);
                }
                if ($request->manager_id != 0 || $request->manager_id != Null) {
                    $user->update([
                        "manager_id" => $request->manager_id
                    ]);
                }

                $website->update([
                    "website" => $request->website,
                    "github" => $request->github,
                    "twitter" => $request->twitter,
                    "linkedin" => $request->linkedin,
                    "facebook" => $request->facebook,
                ]);
                $user = DB::table('users')->join('departments', 'users.dept_id', '=', 'departments.id')->join('designations', 'users.designation_id', '=', 'designations.id')->leftJoin("users AS usm", "users.manager_id", "=", "usm.id")->join("user_social_profiles", "user_social_profiles.user_id", "=", "users.id")->select("users.*", "departments.dept_name", "designations.title AS designation", "usm.name AS manager", "user_social_profiles.website", "user_social_profiles.github", "user_social_profiles.twitter", "user_social_profiles.linkedin", "user_social_profiles.facebook")->where("users.email", $request->email)->first();
                return sendSuccessResponse($user, 'Login successful', 200);
            } else {
                return sendErrorResponse('Email and password does not match with our records', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => ["required", "email"],
            "currentPassword" => ["required"],
            "newPassword" => ["required"]
        ]);

        if ($validator->fails()) {
            return sendErrorResponse('Client side validation error', $validator->errors(), 422);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->currentPassword, $user->password)) {
                $user->update([
                    "password" => Hash::make($request->newPassword)
                ]);
                return sendSuccessResponse($user, 'Password updated successfully', 200);
            } else {
                return sendErrorResponse('Current password does not match with our records', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }

    public function getAllEmployees()
    {
        try {
            $user = DB::table('users')->join('departments', 'users.dept_id', '=', 'departments.id')->join('designations', 'users.designation_id', '=', 'designations.id')->leftJoin("users AS usm", "users.manager_id", "=", "usm.id")->join("user_social_profiles", "user_social_profiles.user_id", "=", "users.id")->select("users.*", "departments.dept_name", "designations.title AS designation", "usm.name AS manager", "user_social_profiles.website", "user_social_profiles.github", "user_social_profiles.twitter", "user_social_profiles.linkedin", "user_social_profiles.facebook", "usm.id AS manager_id")->get();
            if ($user) {
                return sendSuccessResponse($user, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Email and password does not match with our records', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }


    public function getSingleEmployees($id)
    {
        try {
            $user = DB::table('users')->join('departments', 'users.dept_id', '=', 'departments.id')->join('designations', 'users.designation_id', '=', 'designations.id')->leftJoin("users AS usm", "users.manager_id", "=", "usm.id")->join("user_social_profiles", "user_social_profiles.user_id", "=", "users.id")->select("users.*", "departments.dept_name", "designations.title AS designation", "usm.name AS manager", "user_social_profiles.website", "user_social_profiles.github", "user_social_profiles.twitter", "user_social_profiles.linkedin", "user_social_profiles.facebook")->where("users.id", "=", $id)->first();
            if ($user) {
                return sendSuccessResponse($user, 'Data retrieved successfully', 200);
            } else {
                return sendErrorResponse('Email and password does not match with our records', 422);
            }
        } catch (\Throwable $e) {
            return sendErrorResponse('Database Error!', $e->getMessage(), 500);
        }
    }



    public function cardsValueCount()
    {
        $users = User::all()->count();
        $roles = Role::all()->count();
        $designations = Designation::all()->count();
        $departments = Department::all()->count();

        $details = array(
            "employees" => $users,
            "roles" => $roles,
            "designations" => $designations,
            "departments" => $departments
        );
        return sendSuccessResponse($details, 'Data retrieved successfully', 200);
    }

    public function allDropdownValues()
    {

        $roles = Role::all();
        $designations = Designation::all();
        $departments = Department::all();

        $details = array(
            "roles" => $roles,
            "designations" => $designations,
            "departments" => $departments
        );
        return sendSuccessResponse($details, 'Data retrieved successfully', 200);
    }
}
