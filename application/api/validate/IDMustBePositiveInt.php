<?php

namespace app\api\validate;

use think\Validate;
use app\api\validate\BaseValidate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'num' => 'in:1,2,3'
    ];

    // protected $message = [
    //     'id'=> 'id参数必须为正整数'
    // ];

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0 ) > 0){
            return true;
        }else{
            return $field.'必须是正整数';
        }
    }

 

}