<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\service\Token as TokenService;
use app\api\validate\OrderPlace;
use app\api\controller\BaseController;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
        //'first' => ['only'=>'second']
    ];

    
    public function placeOrder()
    { 
        (new OrderPlace())->goCheck();
        return 'mzs0229';
    }
}
