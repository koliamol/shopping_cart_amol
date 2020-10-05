<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Orders';
if(Yii::$app->user->isGuest){
	$user_type = 'guest';
	$user_id = Yii::$app->session->getId();
}else{
	$user_type = 'user';
	$user_id = Yii::$app->user->identity->id;
}
?>

<div class="order-index">

    <h3><span class="text-success"><?= 'Total Shopping Cost : &euro; '.$grand_total ?></span>
    <a href="<?= Url::base(true) ?>" class="btn btn-primary pull-right">Countinue Shopping</a>
</h3>
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'order_code',
            'title',
            'price',
            //'category',
            'quantity',
            'address',
            'email',
            'mobile',
            'country',
            //'state',
            //'city',
            'pincode',
            //'address',
            [
                'attribute' => 'image',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::img($data['image'],
                        ['width' => '70px']);
                },
            ],
            'order_date',
            //'modified_date',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


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