<?php

namespace app\api\model;

use think\Db;
use think\Exception;
use think\Model;

class Banner extends BaseModel
{
    protected $hidden =['update_time','delete_time'];
    public function items()
    {
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerById($id)
    {
        // $result = Db::query('select * from banner_item where banner_id=?',[$id]);
        // $result = Db::table('banner_item')
        // ->where(function($query) use ($id){
        //     $query->where('banner_id','=',$id);
        // })
        // ->select();
        // return $result;

        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
}