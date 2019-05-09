<?php
    namespace frontend\controllers;

use yii\web\Controller;

class CaseController extends Controller{
    public function actionIndex(){
        return $this->renderPartial('index');
    }
}