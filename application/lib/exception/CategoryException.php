<?php
namespace app\lib\exception;

class CategorytException extends BaseException
{
    public $code = 404;
    public $msg = '指定的类目不存在，请检查参数';
    public $errorCode = 50000;

}