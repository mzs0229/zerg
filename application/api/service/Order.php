<?php 

namespace app\api\service;

use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;

class Order
{
    protected $oProducts;
    protected $products;

    protected $uid;


    public function place($uid,$oProducts)
    {
        $this ->oProducts = $oProducts;
        $this ->products = $this->getProductsByOrder($oProducts );
        $this ->uid = $uid; 
        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }

        $orderSnap =$this->snapOrder($status);
    }


    private function createOrder(){

    }
    
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] =json_encode($this->getUserAddress());
        $snap['snapName'] =$this->products[0]['name'];
        $snap['snapImg'] =$this->products[0]['main_img_url'];
        
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }

    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id','=',$this->uid)->find();
        if (!$userAddress) {
            throw new UserException(
                [
                    'msg' => '用户收货地址不存在，下单失败',
                    'errorCode' => 60001,
                ]);
        }
        return $userAddress->toArray();
    }

    private function getOrderStatus()
    {
        $status = [
            'pass'=> true,
            'orderPrice'=> 0,
            'totalCount'=> 0,
            'pStatusArray' => []
        ];

        foreach($this->oProducts as $oProduct)
        {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'],$oProduct['count'],$this->products
            );
            if(!$pStatus['haveStock']){
                $status['pass']= false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID,$oCount,$products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];

        for ($i=0;$i<count($products);$i++)
        {
            if($oPID == $products[$i]['id']){
                $pIndex =$i;
            }
        }

        if($pIndex == -1){
            throw new OrderException([
                'msg'=>'id为'.$oPID.'的商品不存在，穿件订单失败'
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price']*$oCount;

            if($product['stock']- $oCount>=0){
                $pStatus['haveStock'] = true;
            }else{

            }

            return $pStatus;
        }
    }

    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach($oProducts as $item)
        {
            array_push($oPIDs,$item['product_id']);
        }
        $products = Product::all($oPIDs)->visible(['id','price','stock','name','main_img_url'])->toArray();
        return $products;
    }
}