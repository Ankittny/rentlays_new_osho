<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsHelpdesk extends Model
{
    use HasFactory;

    public $table = "pms_helpdesks";


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
