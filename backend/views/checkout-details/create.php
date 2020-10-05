<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CheckoutDetails */

$this->title = 'Create Checkout Details';
$this->params['breadcrumbs'][] = ['label' => 'Checkout Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
