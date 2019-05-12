<?php
    namespace frontend\controllers;

use common\models\CaseType;
use yii\web\Controller;

class CaseController extends Controller{

    public function actionIndex(){
        $typeModel = new CaseType();
        $type = $typeModel->find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'case'
        );
        return $this->renderPartial('index',compact('data'));
    }

    public function actionItem(){
        $params =\Yii::$app->request->get();
        $case_id = isset($params['case_id']) ? $params['case_id'] : "";
        $data = array(
            'link' => 'case',
            'prev_id' => '1',
            'next_id' => '7'
        );
        return $this->renderPartial('item',compact('data','case_id'));
    }
}