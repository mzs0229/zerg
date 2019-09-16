<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\service\Token;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\OrderPlace;
use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser']
        //'first' => ['only'=>'second']
    ];

    public function getSummaryByUser($page=1,$size=15)
    {
        (new PagingParameter())->goCheck();
        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid,$page,$size);
        if($pagingOrders->isEmpty()){
            return [
                'data'=>[],
                'current_page'=>$pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address','prepay_id'])->toArray();
        
        return[
            'data'=>$data,
            'current_page'=>$pagingOrders->getCurrentPage()
        ];

    }

    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail)
        {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }
    
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
