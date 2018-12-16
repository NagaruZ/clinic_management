<?php

namespace app\index\model;

use think\Model;

class Doctor extends Model
{
    public function section()
    {
        return $this->belongsTo('Section');
    }

    public function periods()
    {
        return $this->belongsToMany('AppointmentPeriod', 'doctor_arrangement', 'period_id');
    }

    protected function getBirthDateAttr($birth_addr)
    {
        $date = new \DateTime($birth_addr);
        return $date->format('Y-m-d');
    }

    protected function getGenderNameAttr($value, $data)
    {
        $gender_name = [
            0 => '男',
            1 => '女'
        ];
        return $gender_name[$data['gender']];
    }

    public static function login($name, $password)
    {
        $where['username'] = $name;
        $where['password'] = md5($password);
        $user = Doctor::where($where)->find();
        if($user)
        {
            unset($user["password"]);
            session("ext_user", $user);
            session("role", "doctor");
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function logout()
    {
        session("ext_user", NULL);
        session("role", NULL);
        redirect('index/index/index');
    }

    public static function update_password($id, $new_password)
    {
        $where['id'] = $id;
        $user = Doctor::where($where)->update(['password' => md5($new_password)]);
        if($user)
            return true;
        else
            return false;
    }
}
