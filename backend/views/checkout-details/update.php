<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CheckoutDetails */

$this->title = 'Update Checkout Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Checkout Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="checkout-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
