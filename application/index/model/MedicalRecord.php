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

    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

}
