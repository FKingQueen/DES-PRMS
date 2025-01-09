<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFormStatus extends Model
{
    use HasFactory;

    
    public function requestForm()
    {
        return $this->hasMany(RequestForm::class);
    }
    
}
