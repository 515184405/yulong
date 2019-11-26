<?php
namespace backend\controllers;

use common\models\UserDownRecord;
use Yii;
use yii\web\Controller;
use common\models\LoginForm;

/**
 * Site controller
 */
class DownHistoryController extends CommonController
{
    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        //读数据
        $params = \Yii::$app->request->get();
        if(\Yii::$app->request->isAjax){
            $user = UserDownRecord::search($params);
            return $this->convertJson('0','查询成功',$user['list'], $user['count']);
        }
        return $this->render('index');
    }
}