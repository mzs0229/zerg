<?php

namespace app\api\validate;

use think\Validate;
use app\api\validate\BaseValidate;
use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $oProducts = [
        [
            'product_id' => 1,
            'count' => 3
        ],
        [
            'product_id' => 2,
            'count' => 3
        ],
        [
            'product_id' => 3,
            'count' => 3
        ]

    ];
    protected $products = [
        [
            'product_id' => 1,
            'count' => 6
        ],
        [
            'product_id' => 2,
            'count' => 3
        ],
        [
            'product_id' => 3,
            'count' => 2
        ]

    ];
    protected $rule = [
        'products' => 'checkProducts',

    ];
    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values)
    {
        if (!is_array($values)) {
            throw new ParameterException([
                'msg' => '商品參數不正確'
            ]);
        }
        if (empty($values)) {
            throw new ParameterException([
                'msg' => '商品列表不能為空'
            ]);
        }

        foreach ($values as $value) { 
            $this->checkProduct($value);
        }
        return true;
    }
    protected function checkProduct($value)
    { 
        $validte = new BaseValidate($this->singleRule);
        $result = $validte->check($value);
        if(!$result){
            throw new ParameterException([
                'msg'=>'商品列表参数错误'
            ]);
        }
    }
}
