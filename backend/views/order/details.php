<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Details of -: '.$order_code;
$this->params['breadcrumbs'][] = ['label' => 'orders', 'url' => ['/order']];
$this->params['breadcrumbs'][] = $order_code;

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="order-index">
                <h3><span class="text-success"><?= 'Total Cost : &euro; '.$grand_total ?></span></h3>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'order_code',
            'title',
            'price',
            //'category',
            'quantity',
            'email',
            'mobile',
            'country',
            //'state',
            //'city',
            'pincode',
            //'address',
            [
                'attribute' => 'image',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data['image'],
                        ['width' => '70px']);
                },
            ],
            'created_date',
            //'modified_date',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


                </div>
            </div>
        </div>
    </div>
</div>