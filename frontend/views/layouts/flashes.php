<?php
if(!empty(Yii::$app->session->getAllFlashes())){
?>
<div class="col-lg-6">
    <?php foreach(Yii::$app->session->getAllFlashes() as $type => $messages): ?>
    <div class="alert alert-<?= $type ?>" role="alert"><?= $messages ?></div>
    <?php endforeach ?>
</div>
<?php }?>