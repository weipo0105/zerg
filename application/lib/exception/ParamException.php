<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class ParamException extends BaseException {
    Public $code = 400;
    Public $msg = '参数错误！';
    Public $errorCode = 10000;
}