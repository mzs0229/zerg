<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\service\Token;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }
    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }
}
