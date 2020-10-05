<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use common\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\CheckoutDetails;
use common\models\CartDetails;
use frontend\models\Apis;
use common\models\Cart;
use common\models\User;

use yii\data\ArrayDataProvider;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionDetails()
    {
        if(Yii::$app->user->isGuest){
            Yii::$app->session->setFlash('error', 'Please login to see your order.');
            return $this->redirect('login');
        }else{
            $user_id = Yii::$app->user->identity->id;
        }

        $allCart = Cart::find()->where(['user_id'=>$user_id,'status'=>2])->all();
        $allData=[];
        $grand_total=0;
        if(!empty($allCart)){
            $apis = new Apis();
            $allProductData = $apis->getProductIdAsKey();
            foreach($allCart as $key => $cart){
                $allCartDetails = CartDetails::find()->where(['cart_id'=>$cart->id])->all();
                if(!empty($allCartDetails)){
                    $user = User::findOne($cart->user_id);
                    foreach($allCartDetails as $key => $cartDetails){
                        $checkoutDetails = CheckoutDetails::find()->where(['cart_id'=>$cart->id])->one();
                        if(!empty($checkoutDetails)){
                            $order = Order::find()->where(['checkout_details_id'=>$checkoutDetails->id])->one();

                        }
                        $quantity = isset($cartDetails['quantity']) ? $cartDetails['quantity'] : '';
                        $price = isset($allProductData[$cartDetails['product_id']]['price']) ? $allProductData[$cartDetails['product_id']]['price'] : '';
                        $row['order_code'] = isset($order->order_code) ? $order->order_code : '';
                        $row['title'] = isset($allProductData[$cartDetails['product_id']]['title']) ? $allProductData[$cartDetails['product_id']]['title'] : '';
                        $row['price'] = isset($allProductData[$cartDetails['product_id']]['price']) ? $allProductData[$cartDetails['product_id']]['price'] : '';
                        $row['category'] = isset($allProductData[$cartDetails['product_id']]['category']) ? $allProductData[$cartDetails['product_id']]['category'] : '';
                        $row['email'] = isset($user['email']) ? $user['email'] : '';
                        $row['mobile'] = isset($checkoutDetails['mobile']) ? $checkoutDetails['mobile'] : '';
                        $row['quantity'] = isset($cartDetails['quantity']) ? $cartDetails['quantity'] : '';
                        $row['pincode'] = isset($checkoutDetails['pincode']) ? $checkoutDetails['pincode'] : '';
                        $row['country'] = isset($checkoutDetails['country']) ? $checkoutDetails['country'] : '';
                        $row['state'] = isset($checkoutDetails['state']) ? $checkoutDetails['state'] : '';
                        $row['city'] = isset($checkoutDetails['city']) ? $checkoutDetails['city'] : '';
                        $row['address'] = isset($checkoutDetails['address']) ? $checkoutDetails['address'] : '';
                        $row['order_date'] = isset($checkoutDetails['created_date']) ? $checkoutDetails['created_date'] : '';
                        $row['image'] = isset($allProductData[$cartDetails['product_id']]['image']) ? $allProductData[$cartDetails['product_id']]['image'] : '';
                        $total = $quantity*$price;
                        $grand_total += $total;
                        $allData[]=$row;
                    }
                }
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $allData,
            'pagination'=>array(
                'pageSize'=>10,
            )
        ]);

        return $this->render('details', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'grand_total' => $grand_total
        ]);
    }
}
