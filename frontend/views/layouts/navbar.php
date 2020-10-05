<?php 
use yii\helpers\Url;
?>
<!-- Navbar ================================================== -->
<div id="logoArea" class="navbar">
    <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-inner">
        <a class="brand" href="<?= Url::base(true) ?>"><img src="<?= Url::base(true) ?>/themes/images/logo.png" alt="Bootsshop" /></a>
        
        <ul id="topMenu" class="nav pull-right">
            <li class=""><a href="<?= Url::base(true) ?>">Products</a></li>
            <?php if(!Yii::$app->user->isGuest){?>
            <li class=""><a href="<?= Url::base(true) ?>/order/details">Orders</a></li>
            <?php }?>
            <li class=""><a href="#">Contact</a></li>
            <li class="">
				<?php if(Yii::$app->user->isGuest){?>
                	<a href="<?= Url::base(true) ?>/site/login" style="padding-right:0"><span
						class="btn btn-success">Login</span></a>
				<?php }else{?>
					<a href="<?= Url::base(true) ?>/site/logout" data-method="POST" style="padding-right:0"><span
					class="btn btn-success btn-flat">Logout</span></a>
				<?php
				} ?>
                <div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login"
                    aria-hidden="false">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3>Login Block</h3>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal loginFrm">
                            <div class="control-group">
                                <input type="text" id="inputEmail" placeholder="Email">
                            </div>
                            <div class="control-group">
                                <input type="password" id="inputPassword" placeholder="Password">
                            </div>
                            <div class="control-group">
                                <label class="checkbox">
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </form>
                        <button type="submit" class="btn btn-success">Sign in</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>