<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\Order;
use yii\db\Expression;
use frontend\models\Apis;
use common\models\CheckoutDetails;

class CheckoutController extends \yii\web\Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            Yii::$app->session->setFlash('error', 'Please login to place order.');
            return $this->redirect('site/login');
        }
        
        $model = new CheckoutDetails();
        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->request->post('hdn_session_id','');
            if(Yii::$app->user->isGuest){
                $model->session_id=Yii::$app->session->getId();
                $userCartModel = Cart::find()->where(['session_id'=>$user_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
            }else{
                $model->user_id=Yii::$app->user->identity->id;
                $userCartModel = Cart::find()->where(['user_id'=>$user_id,'status'=>1])->orderBy(['id' => SORT_DESC])->one();
            }
            if(!empty($userCartModel)){
                $model->status=1;
                $model->cart_id=$userCartModel->id;
                $model->cart_id=$userCartModel->id;
                $model->created_date=new Expression('NOW()');
                $model->modified_date=new Expression('NOW()');
                if($model->save()){
                    if(!empty($userCartModel)){
                        $userCartModel->status=2;
                        $userCartModel->save();
                    }
                    /* Create Order*/
                    $order_code = Yii::$app->security->generateRandomString(12);
                    $order = new Order();
                    $order->checkout_details_id=$model->id;
                    $order->order_code=$order_code;
                    $order->status=1;
                    $order->created_date=new Expression('NOW()');
                    $order->modified_date=new Expression('NOW()');
                    if($order->save()){
                        Yii::$app->session->setFlash('success', 'Order placed successfully. your order number is: '.$order_code);
                    }else{
                        Yii::$app->session->setFlash('error', $order->getErrors());
                        return $this->redirect(['index']);
                    }
                }else{
                    Yii::$app->session->setFlash('error', $model->getErrors());
                    return $this->redirect(['index']);
                }
            }else{
                Yii::$app->session->setFlash('error', 'Your shopping cart is empty.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
       
    }
}
