<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="order-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'checkout_details_id',
            //'order_code',
            [
                'attribute' => 'order_code',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::a($data['order_code'],['/order/details','order_code'=>$data['order_code'],'checkout_details_id'=>$data['checkout_details_id']]);
                },
            ],
            //'status',
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