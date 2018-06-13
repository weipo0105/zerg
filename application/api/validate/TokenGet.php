<?php
namespace app\api\validate;

class TokenGet extends BaseValidate
{
    protected $rule = [
        'code'=>'require|isNotEmpty'
    ];
    protected $message = [
        'code'=>'没有传入code参数！',
    ];
}