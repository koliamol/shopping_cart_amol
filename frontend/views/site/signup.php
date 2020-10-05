<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->user->isGuest){
	$user_type = 'guest';
	$user_id = Yii::$app->session->getId();
}else{
	$user_type = 'user';
	$user_id = Yii::$app->user->identity->id;
}
?>
<div class="row">
    <div class="span12">
        <div class="well">
            <h5>Please fill out the following fields to signup</h5><br />
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <input type="hidden" name="hdn_session_id" id="hdn_session_id" value="<?= $user_id ?>" />
            <div class="control-group">
                <div class="controls">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="controls">
                    <?= $form->field($model, 'email') ?>
                </div>
                <div class="controls">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
            </div>
            <div class="controls">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?><br /><br />
                <?= Html::a('I already have account click to login ?', ['site/login']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="span1"> &nbsp;</div>
</div>
<?php
$script = <<< JS
$(document).ready(function () {
	function updateCart(user_id){
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		var data = {'user_id': user_id, "_csrf":csrfToken};
		$.ajax({
			url: baseURL + '/cart/getcartcount',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(responce) {
				if(responce.status==false){
					$(".number_of_cart_item").html("0");
				}else{
					$(".number_of_cart_item").html(responce.count);
				}
			},
		});
    }
    
	var user_id = "$user_id";
	updateCart(user_id);
    if(user_id==''){
        location.reload();
    }
});
JS;
$this->registerJs($script);