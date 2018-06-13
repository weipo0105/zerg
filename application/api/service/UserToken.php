<?php
namespace app\api\service;
use think\Exception;
use app\lib\exception\WeChatException;
use app\api\model\User as UserModel;
class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }
    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);

        if(!$wxResult)
        {
            throw new Exception('获取session_key及openid时异常，微信内部错误！');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail)
            {
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }
    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }

    private function prepareCachedValue($wxResult,$uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('secure.token_expire_in');
        $request = cache($key,$value,$expire_in);
        if(!$request)
        {
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }

    private function grantToken($wxResult)
    {
        //拿到openid
        $openid = $wxResult['openid'];
        //到数据库里看openid是否已经存在
        $user = UserModel::getByOpenID($openid);
        if($user)
        {
            $uid = $user->id();
        }else{
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
        //如果存在，则不处理，否则，新增一条数据
        //生成令牌，准备缓存数据，写入缓存
        //把令牌返回到客户端

    }
    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg'=>$wxResult['errMsg'],
            'errorCode'=>$wxResult['errCode'],
        ]);
    }
}