<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsOnboard extends Model
{
    use HasFactory;


    public function property()
    {
        return $this->belongsTo(Properties::class);
    }

}
