<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
/*
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}'
];
*/
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}',
    'buttons' => [
        'view' => function ($url, $model) {
            return Html::a('<span class="fas fa-eye"></span>', $url, 
            ['title' => Yii::t('app', 'View'),
            'class' => 'btn btn-info btn-sm'
            ]);
        },
    ],
];

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="assignment-index">
                    <?php Pjax::begin(); ?>
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => $columns,
                        ]);
                        ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>