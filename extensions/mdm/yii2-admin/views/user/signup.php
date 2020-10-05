<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = Yii::t('rbac-admin', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'retypePassword')->passwordInput() ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('rbac-admin', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?= Html::a('I already have a membership', ['/admin/user/login']) ?>

    </div>
    <!-- /.form-box -->
</div><!-- /.card -->