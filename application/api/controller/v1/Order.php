<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
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
        $products = input('post.products/a');
      
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
}
