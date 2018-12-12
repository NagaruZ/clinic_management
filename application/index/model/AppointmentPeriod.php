<?php

namespace app\index\model;

use think\Model;

class AppointmentPeriod extends Model
{
    public function doctor_arrangement()
    {
        return $this->hasMany('DoctorArrangement', 'period_id');
    }

    protected function getStartTimeAttr($start_time)
    {
        $time = new \DateTime($start_time);
        return $time->format('H:i');
    }

    protected function getEndTimeAttr($end_time)
    {
        $time = new \DateTime($end_time);
        return $time->format('H:i');
    }
}
