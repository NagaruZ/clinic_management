<?php

namespace app\index\model;

use think\Model\Pivot;

class DoctorArrangement extends Pivot
{

    protected $insert = ['is_free' => 1];
}
