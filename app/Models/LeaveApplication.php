<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaveCategory',
        'user_id',
        'noOfDays',
        'dateFiled',
        'dateOfLeave',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveApplicationStatus()
    {
        return $this->belongsTo(LeaveApplicationStatus::class);
    }
}
