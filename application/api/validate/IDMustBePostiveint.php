<?php
namespace app\api\validate;
class IDMustBePostiveint extends BaseValidate
{
    protected $rule=[
        'id'=>'isPostiveInt',
    ];
    protected $message=[
        'id'=>'必须是正整数',
    ];

}