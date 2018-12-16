<?php

namespace app\index\model;

use think\Model;

class CheckItem extends Model
{
    public function prescriptions()
    {
        return $this->belongsToMany('Prescription', 'prescription_detail');
    }
}
