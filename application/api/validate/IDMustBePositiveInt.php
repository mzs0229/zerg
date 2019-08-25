<?php

namespace app\api\validate;

use think\Validate;
use app\api\validate\BaseValidate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
       
    ];

    protected $message = [
        'id'=> 'id参数必须为正整数'
    ];


}