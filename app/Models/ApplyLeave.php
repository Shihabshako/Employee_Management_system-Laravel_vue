<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyLeave extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type_of_leave_id', 'from', 'to', 'subject', 'details', 'approved_by_manager', 'approved_by_administration'];
}
