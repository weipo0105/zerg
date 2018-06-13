<?php
namespace app\api\validate;

class IDCollection extends BaseValidate
{
    protected $rule=[
        'ids'=>'require|checkIDs'
    ];
    protected $message=[
        'ids'=>'ids参数必须是以逗号分隔的多个正整数!',
    ];
    //$value: ids=id1,id2,id3...
    public function checkIDs($value)
    {
        $values = explode(',',$value);
        if(empty($values))
        {
            return false;
        }
        foreach($values as $id)
        {
            if(!$this->isPostiveInt($id))
            {
                return false;
            }
        }
        return true;
    }

}