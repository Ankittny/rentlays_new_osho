<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cache;

class warehouetype extends Model
{
    use HasFactory;
    protected $table   = 'ware_house_type';
    public $timestamps = false;
    
    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.property.types.warehouse');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.property.types.warehouse', $data);
        }
        return $data;
    }
}
