<?php

namespace backend\controllers;

use yii\rest\ActiveController;

class ProductsApiController extends ActiveController
{
    public $modelClass = 'common\models\Products';

    public function actionGetName(){
        return 'aaaaaaaaaaaaaa';
    }
}
