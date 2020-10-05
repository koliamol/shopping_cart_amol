<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\CartDetails;
use common\models\Products;
use frontend\models\Apis;
use yii\db\Expression;

class ProductsController extends \yii\web\Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAddtocart()
    {
        if (Yii::$app->request->getIsAjax()) {
            $data=[];
            $request = \Yii::$app->request->post();
            if(empty($request)){
                return array('status'=>false,'data'=> 'Request cannot be blank');
            }
            $user_id = isset($request['user_id']) ? $request['user_id'] : '';
            $user_type = isset($request['user_type']) ? $request['user_type'] : '';
            $product_id = isset($request['product_id']) ? $request['product_id'] : '';
            $_csrf = isset($request['_csrf']) ? $request['_csrf'] : '';
            $quantity = isset($request['quantity']) ? $request['quantity'] : '1';
            if($user_id==''){
                return array('status'=>false,'data'=> 'User id can not blank');
            }else if($product_id==''){
                return array('status'=>false,'data'=> 'Product id can not blank');
            }

            if(Yii::$app->user->isGuest){
                $userCartModel = Cart::find()->where(['session_id'=>Yii::$app->session->getId(),'status'=>1])->orderBy(['id' => SORT_DESC])->one();
            }else{
                $userCartModel = Cart::find()->where(['user_id'=>$user_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
            }

            if(!empty($userCartModel)){
                // Check if product exist in cart
                $userCartDetailsModel = CartDetails::find()->where(['cart_id'=>$userCartModel->id,'product_id'=>$product_id])->one();
                if(empty($userCartDetailsModel)){
                    $cartDetails = new CartDetails();
                    $cartDetails->cart_id=$userCartModel->id;
                    $cartDetails->product_id=isset($request['product_id']) ? $request['product_id'] : '';
                    $cartDetails->quantity=isset($request['quantity']) ? $request['quantity'] : '1';
                    $cartDetails->status=1;
                    $cartDetails->created_date = new Expression('NOW()');
                    $cartDetails->modified_date = new Expression('NOW()');
                    if($cartDetails->save()){
                        $data = array('status'=>true,'data'=> 'Product added to cart');
                    }else{
                        $data = array('status'=>false,'data'=>$cartDetails->getErrors());
                    }
                }else{
                    //Product Exist in cart
                    $data = array('status'=>false,'data'=>'Product already exists in your cart');   
                }
            }else{
                $cart = new Cart();
                if(Yii::$app->user->isGuest){
                    $cart->session_id = Yii::$app->session->getId();
                }else{
                    $cart->session_id = Yii::$app->session->getId();
                    $cart->user_id = isset($request['user_id']) ? $request['user_id'] : '';
                }
                $cart->status = 1;
                $cart->created_date = new Expression('NOW()');
                if($cart->save()){
                    $cartDetails = new CartDetails();
                    $cartDetails->cart_id=$cart->id;
                    $cartDetails->product_id=isset($request['product_id']) ? $request['product_id'] : '';
                    $cartDetails->quantity=isset($request['quantity']) ? $request['quantity'] : '1';
                    $cartDetails->status=1;
                    $cartDetails->created_date = new Expression('NOW()');
                    $cartDetails->modified_date = new Expression('NOW()');
                    if($cartDetails->save()){
                        $data = array('status'=>true,'data'=> 'Product added to cart');
                    }else{
                        $data = array('status'=>false,'data'=>$cartDetails->getErrors());
                    }
                }else{
                    $data = array('status'=>false,'data'=>$cart->getErrors());
                }
            }
            return json_encode($data);
        }
        return false;
    }

    public function actionDetails()
    {
        $request = \Yii::$app->request->get();
        if(!empty($request)){
            $apis = new Apis();
            $allData = $apis->getProduct($request['product_id']);
            return $this->render('details',[
                'allData' => isset($allData) ? $allData : [],
            ]);
        }else{
            $this->goHome();
        }
    }

}
