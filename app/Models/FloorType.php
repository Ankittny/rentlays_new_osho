<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cache;
class FloorType extends Model
{
    use HasFactory;
    protected $table   = 'floor_type';
    public $timestamps = false;

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.property.types.floortype');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.property.types.floortype', $data);
        }
        return $data;
    }
}
