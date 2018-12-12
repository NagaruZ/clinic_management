<?php

namespace app\index\model;

use think\Model;

class MedicalRecord extends Model
{
    public function prescription()
    {
        return $this->hasOne('Prescription');
    }

    public function appointment()
    {
        return $this->belongsTo('Appointment');
    }
}
