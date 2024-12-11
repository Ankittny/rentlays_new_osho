<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaskList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function property()
    {
        return $this->hasOne('App\Models\Properties', 'id', 'property_id');
    }

}
