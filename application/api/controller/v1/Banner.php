<?php
namespace app\api\controller\v1;
//use think\Validate;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveint;
use app\lib\exception\BannerMissException;
use think\Exception;
class Banner{
    /*
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     * */
    public function getBanner($id){
        (new IDMustBePostiveint())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}