<?php
namespace frontend\controllers;

use common\models\Widget;
use Yii;


/**
 * Site controller
 */
class WidgetController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionWidget()
    {
        $id = Yii::$app->request->get('id');
        $title = Yii::$app->request->get('title');
        $dir = Yii::$app->request->get('dir');
        $create_time = Yii::$app->request->get('create_time');
        $model = Widget::findOne($id);
        if(!isset($id) || !isset($create_time) || !$model || ($model->create_time != $create_time)){
            return '没有此项目';
        }
        //静态文件路由
        $url = '/'.Yii::$app->params['widget_dir'].'/'.$id.'/';
        $view_url = '/widget/widget/'.$create_time.'/'.$id.'/';
        return $this->renderPartial($id.'/'.$title.'.html',compact('url','view_url'));
    }
}
