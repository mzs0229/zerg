<?php
namespace app\lib\exception;

class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '制定类目不存在，请检查主题ID';
    public $errorCode = 50000;
}