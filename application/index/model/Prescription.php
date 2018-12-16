<?php

namespace app\index\model;

use think\Model;

class Prescription extends Model
{
    public function items()
    {
        return $this->belongsToMany('CheckItem', 'prescription_detail');
    }

    public function medical_record()
    {
        return $this->belongsTo('MedicalRecord');
    }

    public function payment()
    {
        return $this->hasOne('payment');
    }

}
