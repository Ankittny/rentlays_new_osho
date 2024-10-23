<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsHistory extends Model
{
    use HasFactory;

    protected $table = 'pms_history';
    protected $guarded = [];

    public function  getHelpdesk()
    {
        return $this->hasOne(Admin::class,'id','helpdesk_user_id');
    }

    public function  getSupervisor()
    {
        return $this->hasOne(Admin::class,'id','assign_to_supervisor');
    }

    public function property_name(){
        return $this->hasOne(Properties::class,'id','property_id');
    }

}
