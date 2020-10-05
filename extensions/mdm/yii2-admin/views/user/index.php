<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;
use kartik\select2\Select2;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'username',
    'email:email',
    [
        'attribute' => 'status',
        'value' => function($model) {
            return $model->status == 0 ? 'Inactive' : 'Active';
        },
        'filter' => [
            0 => 'Inactive',
            10 => 'Active'
        ]
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
        'buttons' => [
            'activate' => function($url, $model) {
                if ($model->status == 10) {
                    return '';
                }
                $options = [
                    'title' => Yii::t('rbac-admin', 'Activate'),
                    'aria-label' => Yii::t('rbac-admin', 'Activate'),
                    'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="fa fa-check success"></span>', $url, $options);
            },
            'delete' => function ($url, $model) {
                return Html::a('<i class="fas fa-trash danger"></i>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn btn-danger btn-sm'
                ]);
            }
            ]
        ],
    ];
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="user-index">
                    <?php /*echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'target' => ExportMenu::TARGET_SELF,
                        'dropdownOptions' => [
                            'label' => 'Export',
                            'class' => 'btn btn-success ',
                        ],
                        'columnSelectorOptions' => [],
                        'showColumnSelector' => FALSE,
                        'fontAwesome' => true,
                        'formatter' => [
                            'class' => 'yii\i18n\Formatter',
                            'nullDisplay' => '-',
                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL => false,
                        ],
                        'filename' => $this->title . '_' . time(),
                        'showConfirmAlert' => false
                    ]);
                    */ ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumns
                        ]);
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
