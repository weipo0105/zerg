<?php
namespace app\api\validate;

class Count extends BaseValidate
{
    protected  $rule = [
        'count'=>'isPostiveInt|between:1,15',
    ];
}