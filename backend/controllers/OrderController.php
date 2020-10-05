<?php

namespace backend\controllers;

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
        $checkout_details_id = Yii::$app->request->get('checkout_details_id','');
        $order_code = Yii::$app->request->get('order_code','');
        $checkoutDetails = CheckoutDetails::findOne($checkout_details_id);
        
        $allData=[];
        $grand_total=0;
        if(!empty($checkoutDetails)){
            $allCartDetails = CartDetails::find()->where(['cart_id'=>$checkoutDetails->cart_id])->all();
            $cart = Cart::findOne($checkoutDetails->cart_id);
            $user = User::findOne($cart->user_id);
            $apis = new Apis();
            $allProductData = $apis->getProductIdAsKey();

            foreach($allCartDetails as $key => $cartDetails){
                $quantity = isset($cartDetails['quantity']) ? $cartDetails['quantity'] : '';
                $price = isset($allProductData[$cartDetails['product_id']]['price']) ? $allProductData[$cartDetails['product_id']]['price'] : '';
                $row['order_code'] = isset($order_code) ? $order_code : '';
                $row['title'] = isset($allProductData[$cartDetails['product_id']]['title']) ? $allProductData[$cartDetails['product_id']]['title'] : '';
                $row['price'] = isset($allProductData[$cartDetails['product_id']]['price']) ? $allProductData[$cartDetails['product_id']]['price'] : '';
                $row['category'] = isset($allProductData[$cartDetails['product_id']]['category']) ? $allProductData[$cartDetails['product_id']]['category'] : '';
                $row['image'] = isset($allProductData[$cartDetails['product_id']]['image']) ? $allProductData[$cartDetails['product_id']]['image'] : '';
                $row['quantity'] = isset($cartDetails['quantity']) ? $cartDetails['quantity'] : '';
                $row['email'] = isset($user['email']) ? $user['email'] : '';
                $row['mobile'] = isset($checkoutDetails['mobile']) ? $checkoutDetails['mobile'] : '';
                $row['country'] = isset($checkoutDetails['country']) ? $checkoutDetails['country'] : '';
                $row['state'] = isset($checkoutDetails['state']) ? $checkoutDetails['state'] : '';
                $row['city'] = isset($checkoutDetails['city']) ? $checkoutDetails['city'] : '';
                $row['city'] = isset($checkoutDetails['city']) ? $checkoutDetails['city'] : '';
                $row['pincode'] = isset($checkoutDetails['pincode']) ? $checkoutDetails['pincode'] : '';
                $row['address'] = isset($checkoutDetails['address']) ? $checkoutDetails['address'] : '';
                $row['created_date'] = isset($checkoutDetails['created_date']) ? $checkoutDetails['created_date'] : '';
                $total = $quantity*$price;
                $grand_total += $total;
                $allData[]=$row;
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
            'grand_total' => $grand_total,
            'order_code' => $order_code,
        ]);
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
