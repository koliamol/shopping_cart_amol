<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CartDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cart Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="cart-details-index">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'value' => 'userName',
                'label' => 'User'
            ],
            [
                'attribute' => 'product.name',
                'format' => 'raw',
                'label' => 'Product Name'
            ],
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'label' => 'Quantity',
            ],
            [
                'attribute' => 'created_date',
                'format' => 'raw',
                'label' => 'Created Date',
            ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


                </div>
            </div>
        </div>
    </div>
</div>