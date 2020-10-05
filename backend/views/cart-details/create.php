<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CartDetails */

$this->title = 'Create Cart Details';
$this->params['breadcrumbs'][] = ['label' => 'Cart Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
