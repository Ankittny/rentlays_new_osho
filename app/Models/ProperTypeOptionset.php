<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProperTypeOptionset extends Model
{
    use HasFactory;
    protected $table = 'property_option_type_set';
    protected $fillable = [
        'id', 
        'property_type_id',
        'property_option_type_id',
    ];

    public function propertyOptionTypeSets()
    {
        return $this->hasMany(ProperTypeOptionset::class, 'property_option_type_id');
    }

}
