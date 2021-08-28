<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'HireDate',
    ];

    public function attendance()
    {
        return $this->hasOne(attendance::class,'employee');
    }

}
