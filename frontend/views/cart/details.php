<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'Cart Details';
if(Yii::$app->user->isGuest){
	$user_type = 'guest';
	$user_id = Yii::$app->session->getId();
}else{
	$user_type = 'user';
	$user_id = Yii::$app->user->identity->id;
}
?>
<ul class="breadcrumb">
    <li><a href="<?= Url::base(true) ?>">Home</a> <span class="divider">/</span></li>
    <li><a href="<?= Url::base(true) ?>">Products</a> <span class="divider">/</span></li>
    <li class="active"> Cart</li>
</ul>
<h3> SHOPPING CART [ <small><span class="number_of_cart_item"></span> Item(s) </small>]
<a href="<?= Url::base(true) ?>/checkout" class="btn btn-success pull-right">Checkout <i class="icon-arrow-right"></i></a>
</h3>
<hr class="soft" />
<?php 
if(Yii::$app->user->isGuest){
?>
<table class="table table-bordered">
    <tr>
        <th> I AM ALREADY REGISTERED </th>
    </tr>
    <tr>
        <td>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <input type="hidden" name="hdn_session_id" id="hdn_session_id" value="<?= $user_id ?>"/>
                <div class="control-group">
                    <div class="controls">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        
                        <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        OR <?= Html::a('Register Now', ['site/signup']) ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?= Html::a('Forgot password', ['site/request-password-reset']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </td>
    </tr>
</table>
<?php }?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Title</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($data)){
            $total_price=0;
            foreach($data as $key => $value){               
                $quantity = isset($value['quantity']) ? (int) trim($value['quantity']) : '';
                $price = isset($value['product_details']['price']) ?  trim($value['product_details']['price']) : '';
                $total = ($quantity*$price);
                $total_price += $total;
            ?>
            <tr>
                <td><img width="60" src="<?= isset($value['product_details']['image']) ? $value['product_details']['image'] : '';?>" alt="" /></td>
                <td><?= isset($value['product_details']['title']) ? $value['product_details']['title'] : '';?></td>
                <td><?= isset($value['product_details']['description']) ? $value['product_details']['description'] : '';?></td>
                <td><?= isset($value['quantity']) ? $value['quantity'] : '';?></td>
                <td><?= isset($value['product_details']['price']) ? $value['product_details']['price'] : '';?></td>
                <td><?=isset($total) ? $total : '';?></td>
            </tr>
            <?php 
            }
            ?>
            <tr>
                <td colspan="5" style="text-align:right">Total Price: </td>
                <td><?= isset($total_price) ? $total_price : '0' ?></td>
            </tr>
        <?php
        }else{?>
            <td colspan="6" style="text-align:center">Your cart is empty. Please add product in your cart.</td>
        <?php
        }
        ?>
        
    </tbody>
</table>
<a href="<?= Url::base(true) ?>" class="btn btn-primary"><i class="icon-arrow-left"></i> Continue Shopping </a>
<a href="<?= Url::base(true) ?>/checkout" class="btn btn-success pull-right">Checkout <i class="icon-arrow-right"></i></a>

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
JS;
$this->registerJs($script);