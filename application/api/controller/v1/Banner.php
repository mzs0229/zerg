<?php

namespace app\api\controller\v1;

use think\Validate;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    public function getBanner($id)
    {


        (new IDMustBePositiveInt())->goCheck();
        // $banner = BannerModel::with(['items','items.img'])->find($id);
        $banner = BannerModel::getBannerById($id);
       
        if(!$banner){
            throw new BannerMissException();
        }
      
        return $banner;

        
       
    }
}