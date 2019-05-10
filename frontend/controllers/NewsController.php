<?php
namespace frontend\controllers;

use yii\web\Controller;

class NewsController extends Controller{
    public function actionIndex(){
        return $this->renderPartial('index');
    }
}