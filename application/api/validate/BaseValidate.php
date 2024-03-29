<?php

namespace app\api\validate;

use think\Exception;
use think\Request;
use think\Validate;
use app\lib\exception\ParameterException;


class BaseValidate extends Validate
{
	public function goCheck()
	{
		//获取HTTP传入的参数
		//对这些参数进行校验
		$request = Request::instance();
		$params = $request->param();

		$result = $this->batch()->check($params);
		if(!$result){
			$e = new ParameterException([
				'msg' => $this->error
				// 'code' => 400,
				// 'errorCode' => 100002
			]);
			// $e->msg = $this->error;
			// $e->errorCode = 10002;
			throw $e;
			
			// $error = $this->error;
			// throw new Exception($error);
		}
		else{
			return true;
		}
	}

	protected function isPositiveInteger($value, $rule = '', $data ='', $field = '')
	{
		if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
			return true;
		}
		else{
			return false;
			//return $field.'必须是正整数';
		}
	}

	protected function isMobile($value)
	{
		$rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
		$result = preg_match($rule, $value);
		if($result)
		{
			return true;
		}else{
			return false;
		}
	}

	protected function isNotEmpty($value, $rule = '', $data ='', $field = '')
	{
		if(empty($value)){
			// return $field.'不允许为空';
			return false;
		}
		else{
			return true;
		}
	}

	public function getDataByRule($arrays)
	{
		if(array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays))
		{
			throw new ParameterException([
				'msg' => '参数中包含非法的参数名user_id或者uid'
			]);
		}
		$newArray = [];
		foreach ($this->rule as $key => $value)
		{
			$newArray[$key] = $arrays[$key];
		}
		return $newArray;
	}
 
}



