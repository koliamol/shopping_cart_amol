<?php
use yii\helpers\Url;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Backend</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
       

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    
                    ['label' => 'Products', 'icon' => 'table', 'url' => ['/products']],
                    ['label' => 'Orders', 'icon' => 'shopping-cart', 'url' => ['/order']],
                    [
                        'label' => 'RBAC',
                        'icon' => 'cogs',
                        'url' => ['/admin/user'],
                        
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>