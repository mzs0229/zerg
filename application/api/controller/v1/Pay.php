<?php

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use think\Controller;
use think\Request;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
        //'first' => ['only'=>'second']
    ];

    public function getPreOrder($id='')
    {
        (new IDMustBePositiveInt())-goCheck();
    }
}
