<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'My Shop';
if(Yii::$app->user->isGuest){
	$user_type = 'guest';
	$user_id = Yii::$app->session->getId();
}else{
	$user_type = 'user';
	$user_id = Yii::$app->user->identity->id;
}
?>
<div class="row">
    <div id="gallery" class="span3">
        <a href="<?= isset($allData['image']) ? $allData['image'] : '';?>"
            title="<?= isset($allData['title']) ? $allData['title'] : '';?>">
            <img src="<?= isset($allData['image']) ? $allData['image'] : '';?>" style="width:100%"
                alt="<?= isset($allData['title']) ? $allData['title'] : '';?>" />
        </a>

        <div class="btn-toolbar">
            <div class="btn-group">
                <span class="btn"><i class="icon-envelope"></i></span>
                <span class="btn"><i class="icon-print"></i></span>
                <span class="btn"><i class="icon-zoom-in"></i></span>
                <span class="btn"><i class="icon-star"></i></span>
                <span class="btn"><i class="icon-thumbs-up"></i></span>
                <span class="btn"><i class="icon-thumbs-down"></i></span>
            </div>
        </div>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="<?= Url::base(true) ?>">Home</a> <span class="divider"></span></li>
            <li class="active">Products Details</li>
        </ul>
        <h3><?= isset($allData['title']) ? $allData['title'] : '';?></h3>
        <hr class="soft" />
        <div class="form-horizontal qtyFrm">
            <div class="control-group">
                <label class="control-label">Price:
                    <span>&euro;<?= isset($allData['price']) ? $allData['price'] : '';?></span></label>
                <div class="controls">
                    <button data-id="<?= $allData['id']?>" data-user_id="<?= $user_id?>"
                        data-user_type="<?= $user_type?>" class="btn btn-success pull-right add_to_cart"> Add to cart <i
                            class=" icon-shopping-cart"></i></button>
                    
                </div>
            </div>
        </div>
        <hr class="soft" />
        <p>
            <?= isset($allData['description']) ? $allData['description'] : '';?>
        </p>
        <br class="soft" />
    </div>


</div>
<?php
$script = <<< JS
$(document).ready(function () {
    $(".add_to_cart").on('click', function(event){
		var product_id = $(this).attr("data-id");
		var user_id = $(this).attr("data-user_id");
		var user_type = $(this).attr("data-user_type");
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		if(product_id != '' && user_id!="" && user_type != ''){
			var data = {'user_type':user_type, 'user_id': user_id, 'product_id': product_id, "_csrf":csrfToken};
			$.ajax({
				url: baseURL + '/products/addtocart',
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function(responce) {
					if(responce.status==false){
						alert(responce.data)
					}else{
						alert(responce.data)
						updateCart(user_id);
					}
				},
			});
		}
	});

	function updateCart(user_id){
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		var data = {'user_id': user_id, "_csrf":csrfToken};
		$.ajax({
			url: baseURL + '/cart/getcartcount',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(responce) {
                //alert(responce.status);
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