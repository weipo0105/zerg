<?php
namespace app\api\validate;
use think\Validate;

class TestValidate extends Validate{
    protected $rule = array(
        'id'=>'require|max:10',
    );
}