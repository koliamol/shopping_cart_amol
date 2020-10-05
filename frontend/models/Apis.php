<?php

namespace frontend\models;

use Yii;

/**
 * Product is the model behind the contact form.
 */
class Apis
{
    public function getProducts()
    {
        $url = "https://fakestoreapi.com/products";
        return Yii::$app->commonUtility->doCurl($url);
    }

    public function getProduct($id)
    {
        $url = "https://fakestoreapi.com/products/".$id;
        return Yii::$app->commonUtility->doCurl($url);
    }

    public function getProductIdAsKey()
    {
        $return = [];
        $url = "https://fakestoreapi.com/products/";
        $data = Yii::$app->commonUtility->doCurl($url);
        if(!empty($data)){
            foreach($data as $key => $value){
                $return[$value['id']]=$value;
            }
        }
        return $return;
    }
}
