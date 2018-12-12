<?php

namespace app\index\model;

use think\Model;

class Section extends Model
{
    public function doctors()
    {
        return $this->hasMany('Doctor');
    }
}
