<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Checkout';
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
            <h5>Please fill out the following fields to Checkout:</h5><br />
            <?php $form = ActiveForm::begin(); ?>
            <input type="hidden" name="hdn_session_id" id="hdn_session_id" value="<?= $user_id ?>" />
            <table style="border: 5px;" width="100%">
                <tr>
                    <td width="50%">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                    </td>
                    <td width="50%">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                    <?= $form->field($model, 'mobile')->textInput() ?>
                    </td>
                    <td width="50%">
                    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                    <?= $form->field($model, 'state')->textInput() ?>
                    </td>
                    <td width="50%">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                    <?= $form->field($model, 'pincode')->textInput() ?>
                    </td>
                    <td width="50%">
                    <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
                    </td>
                </tr>
            </table>
            
            <div class="controls">
                <?= Html::submitButton('Place Order', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                <a class="btn btn-primary" href="<?= Url::base(true) ?>">Countinue Shopping</a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="span1"> &nbsp;</div>
</div>
<?php
$script = <<< JS
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
JS;
$this->registerJs($script);