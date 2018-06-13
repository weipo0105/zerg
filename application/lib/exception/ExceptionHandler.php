<?php
namespace app\lib\exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle{
    private $code;
    private $msg;
    private $errorCode;
    //需要返回客户端当前请求的URl
    public function render(\Exception $e){
        if($e instanceof BaseException){
            //TODO:如果是自定义异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            if(config('app_debug')){
                //返回框架默认的错误页面
                return parent::render($e);

            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误，就是不想告诉你';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }

        }
        $request = Request::instance();
        $result = [
            'code'=>$this->code,
            'msg'=>$this->msg,
            'error_code'=>$this->errorCode,
            'request_url'=>$request->url(),
        ];
        return json($result,$this->code);
    }

    private function recordErrorLog(\Exception $e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error'],
        ]);
        Log::record($e->getMessage(),'error');
    }
}