<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CheckoutDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Checkout Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Checkout Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'session_id',
            'cart_id',
            'first_name',
            'last_name',
            'mobile',
            'country',
            'state',
            'city',
            'pincode',
            'address:ntext',
            'status',
            'created_date',
            //'modified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
