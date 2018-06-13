<?php
namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveint;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count=15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty())
        {
            throw new ProductException();
        }
        //$colletion = collection($products);
        $products = $products->hidden(['summary']);
        return $products;
    }
    public function getAllInCategory($id)
    {
        (new IDMustBePostiveint())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty())
        {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
}