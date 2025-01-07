<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicationStatus extends Model
{
    use HasFactory;

    public function leaveApplication()
    {
        return $this->hasMany(leaveApplication::class);
    }
    
}
