<?php

namespace app\api\controller\v1;

use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
   public function createOrUpdateAddress()
   {
       $validate = new AddressNew();
       $validate->goCheck();
       $uid = TokenService::getCurrentUid();
       $user = UserModel::get($uid);
       if(!$user){
           throw new UserException();
       }
       $dataArray = $validate->getDataByRule(input('post.'));
       $userAddress = $user->address;
       if(!$userAddress)
       {
            $user->address()->save($dataArray);
       }else{
           $user->address->save($dataArray);
       }
       return json(new SuccessMessage(),201);
   }
}