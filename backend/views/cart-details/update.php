<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CartDetails */

$this->title = 'Update Cart Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cart Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cart-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
