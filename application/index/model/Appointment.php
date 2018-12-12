<?php

namespace app\index\model;

use think\Model;

class Appointment extends Model
{
    public function doctor()
    {
        return $this->belongsTo('Doctor');
    }

    public function patient()
    {
        return $this->belongsTo('Patient');
    }

    public function period()
    {
        return $this->belongsTo('AppointmentPeriod','period_id');
    }

    protected $insert = [
        'is_cancelled' => 0,
        'is_finished' => 0,
    ];

    protected function getCancelStatusAttr($value, $data)
    {
        $status = [
            0 => '未取消',
            1 => '已取消'
        ];
        return $status[$data['is_cancelled']];
    }

    protected function getFinishStatusAttr($value, $data)
    {
        $status = [
            0 => '未完成',
            1 => '已完成'
        ];
        return $status[$data['is_finished']];
    }
}
