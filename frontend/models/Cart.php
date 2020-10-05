<?php

namespace frontend\models;

use Yii;
use frontend\models\Apis;
use common\models\Cart as userCart;
use common\models\CartDetails;

/**
 * Product is the model behind the contact form.
 */
class Cart
{
    public function getUserCartData()
    {
        $return = [];
        $apis = new Apis();
        $allData = $apis->getProductIdAsKey();
        if(Yii::$app->user->isGuest){
            $session_id = Yii::$app->session->getId();
            $userCartModel = userCart::find()->where(['session_id'=>$session_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
        }else{
            $user_id = Yii::$app->user->identity->id;
            $userCartModel = userCart::find()->where(['user_id'=>$user_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
        }
        if(!empty($userCartModel)){
            $userCartDetailsModel = CartDetails::find()->where(['cart_id'=>$userCartModel->id])->asArray()->all();
            foreach($userCartDetailsModel as $key => $value){
                $return[$key]=$value;
                $return[$key]['product_details']=isset($allData[$value['product_id']]) ? $allData[$value['product_id']] : '';
               
            }
        }
        return $return;
    }
}
