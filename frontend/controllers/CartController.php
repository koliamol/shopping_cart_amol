<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\CartDetails;
use common\models\Products;
use yii\db\Expression;
use common\models\LoginForm;
use frontend\models\Apis;
use frontend\models\Cart as userCart;

class CartController extends \yii\web\Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionDetails(){
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $hdn_session_id = Yii::$app->request->post('hdn_session_id','');
            if($hdn_session_id!=''){
                $cartModel = Cart::findOne(['session_id'=>$hdn_session_id]);
                if(!empty($cartModel)){
                    $cartModel->user_id = Yii::$app->user->identity->id;
                    $cartModel->session_id = Yii::$app->session->getId();
                    $cartModel->status = 1;
                    $cartModel->save();
                }
            }
            if(Yii::$app->request->referrer){
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                return $this->goBack();
            }
        } else {
            $userCart = new userCart();
            $allData = $userCart->getUserCartData();
            return $this->render('details',[
                'model' => $model,
                'data'=> isset($allData) ? $allData : [],
            ]);
        }
    }

    public function actionGetcartcount()
    {
        if (Yii::$app->request->getIsAjax()) {
            $data=array('status'=>false,'count'=>0);
            $request = \Yii::$app->request->post();
            if(empty($request)){
                return array('status'=>false,'data'=> 'Request cannot be blank');
            }
            $user_id = isset($request['user_id']) ? $request['user_id'] : '';
            if(Yii::$app->user->isGuest){
                $userCartModel = Cart::find()->where(['session_id'=>$user_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
            }else{
                $userCartModel = Cart::find()->where(['user_id'=>$user_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
            }

            if(!empty($userCartModel)){
                // Check if product exist in cart
                $userCartDetailsModel = CartDetails::find()->where(['cart_id'=>$userCartModel->id])->count();
                if(!empty($userCartDetailsModel)){
                    $data = array('status'=>true,'count'=>$userCartDetailsModel);
                }else{
                    $data = array('status'=>false,'count'=>0);   
                }
            }else{
                $data = array('status'=>false,'count'=>0);
            }
            return json_encode($data);
        }
        return false;
    }
}
