<?php
use yii\helpers\Url;
use yii\helpers\Html;

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
<br class="clr" />
<div class="tab-content">
    <div class="tab-pane  active" id="blockView">
        <ul class="thumbnails">
            <?php 
			if(isset($data) && !empty($data)) {
				foreach($data as $key => $product){
			?>
            <li class="span3" style="height: 300px">
                <div class="thumbnail">
					<a href="products/details?product_id=<?= $product['id']?>">
					<?= Html::img(isset($product['image']) ? $product['image'] : '', [
					'alt' => 'pic not found',
					'width' => '100px',
					'height' => '250px'
					]); ?> 
					</a>
                    <div class="caption">
                        <h5><?= isset($product['title']) ? $product['title'] : ''; ?></h5>
                        <h4 style="text-align:center">
                            <a class="btn" href="products/details?product_id=<?= $product['id']?>"> <i
                                    class="icon-zoom-in"></i></a>
                            <button class="btn add_to_cart" data-id="<?= $product['id']?>" data-user_id="<?= $user_id?>"
                                data-user_type="<?= $user_type?>">Add to <i class="icon-shopping-cart"></i></button>
                            <button class="btn btn-primary"
                                disabled>&euro;<?= isset($product['price']) ? $product['price'] : ''; ?></button>
                        </h4>
                    </div>
                </div>
            </li>
            <?php }
			}
			?>
        </ul>
    </div>
</div>
<br class="clr" />
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