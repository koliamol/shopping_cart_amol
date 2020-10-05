<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Url::base(true) ?>/themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="<?= Url::base(true) ?>/themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="<?= Url::base(true) ?>/themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="<?= Url::base(true) ?>/apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="<?= Url::base(true) ?>/apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css" id="enject"></style>
    <script>
        var baseURL = "<?= Url::base(true) ?>";
    </script>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="header">
        <div class="container">
            <?= $this->render('top_header');?>
            <?= $this->render('navbar');?>
        </div>
    </div>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
                    <?= $this->render('flashes');?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('footer');?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>