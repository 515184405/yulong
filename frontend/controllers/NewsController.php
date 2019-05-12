<?php
namespace frontend\controllers;

use common\models\NewsType;
use yii\web\Controller;

class NewsController extends Controller{
    public function actionIndex(){
        $typeModel = new NewsType();
        $type = $typeModel->find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'news'
        );
        return $this->renderPartial('index',compact('data'));
    }
    public function actionItem(){
        $params =\Yii::$app->request->get();
        $news_id = isset($params['news_id']) ? $params['news_id'] : "";
        $data = array(
            'link' => 'news',
            'prev_id' => '1',
            'next_id' => '7'
        );
        return $this->renderPartial('item',compact('data','news_id'));
    }
}