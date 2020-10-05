<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

if(Yii::$app->user->isGuest){
	$user_type = 'guest';
    $user_id = Yii::$app->session->getId();
    $username = 'Guest';
}else{
	$user_type = 'user';
    $user_id = Yii::$app->user->identity->id;
    $username = Yii::$app->user->identity->email;
}
?>
<div id="welcomeLine" class="row">
<div class="span6">
        <div class="pull-left">
            Welcome <?= isset($username) ? $username : 'Guest';?>
        </div>
    </div>
    <div class="span6">
        <div class="pull-right">
            <a href="<?= Url::base(true) ?>/cart/details">
                <span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ <span class="number_of_cart_item"></span> ] Itemes in
                    your cart </span> </a>
        </div>
    </div>
    
</div>