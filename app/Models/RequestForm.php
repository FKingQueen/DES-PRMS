<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'emailAddress',
        'date',
        'nameOfRequester',
        'nameOfLearner',
        'schoolYearGraduated',
        'issuedBy',
        'purpose',
        'documentCategory',
    ];

    public function requestFormStatus()
    {
        return $this->belongsTo(RequestFormStatus::class);
    }
}
