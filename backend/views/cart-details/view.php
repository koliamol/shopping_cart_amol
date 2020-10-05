<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CartDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cart Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="cart-details-view">

                    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cart_id',
            'product_id',
            'quantity',
            'status',
            'created_date',
        ],
    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>