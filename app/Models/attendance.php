<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'employee',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(employee::class,'employee');
    }
}
