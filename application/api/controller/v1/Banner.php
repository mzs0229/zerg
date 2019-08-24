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
        // $data = [
        //     'id' => $id
        // ];

        // $validate = new IDMustBePositiveInt();

        // $result = $validate->batch()->check($data);
        // if(!$result){
        //     echo $validate->getError();
        // }else{
        //     echo 'passed';
        // }

        (new IDMustBePositiveInt())->goCheck();
       
        $banner = BannerModel::getBannerById($id);
        if(!$banner){
            throw new BannerMissException();
        }
      
        return json($banner);

        
       
    }
}