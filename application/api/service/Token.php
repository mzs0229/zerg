<?php 

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Request;


class Token
{
	public static function generateToken()
	{
		$randChars = getRandChar(32);
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		$salt = config('secure.token_salt');

		return md5($randChars.$timestamp.$salt);
	}

	public static function getCurrentTokenVar($key)
	{
		$token = Request::instance()
			->header('token');
		$vars = Cache::get($token);
		if(!$vars){
			throw new TokenException();
		}
		else{
			if(!is_array($vars))
			{
				$vars = json_decode($vars,true);
			}
			if(array_key_exists($key, $vars))
			{
				return $vars[$key];
			}
			else{
				throw new Exception('尝试获取的Token变量并不存在');
			}
		}
	}

	public static function getCurrentUid()
	{
		$uid = self::getCurrentTokenVar('uid');
		return $uid;
	}

	public static function needPrimaryScope()
	{
		$scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope>= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
	}

	public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
}

 