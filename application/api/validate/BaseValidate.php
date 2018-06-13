<?php
namespace app\api\validate;
use app\lib\exception\ParamException;
use think\Validate;
use think\Request;
use think\Exception;
class BaseValidate extends Validate{
    public function goCheck(){
        $request = Request::instance();
        $params = $request -> param();

        $result = $this->batch()->check($params);
        if(!$result){
            $e = new ParamException([
                'msg'=>$this->error,
                //'code'=>400,
                //'errorCode'=>10002,
            ]);
            /*$e->msg = $this->error;
            $e->errorCode = 10002;*/
            throw $e;
            /*$error = $this->getError();
            throw new Exception($error);*/
        }else{
            return true;
        }
    }
    protected function isPostiveInt($value,$rule='',$data='',$field=''){
        //dump(is_integer($value));die;
        if(is_numeric($value) && is_int($value+0) && ($value + 0)> 0){
            return true;
        }else{
            return false;
            //return $field.'必须是正整数!';
        }
    }
    public function isNotEmpty($value,$rule='',$data='',$field='')
    {
        if(empty($value))
        {
            return false;
        }else{
            return true;
        }
    }
}