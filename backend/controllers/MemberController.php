<?php
namespace backend\controllers;
use common\models\Member;
use yii\helpers\Json;


/**
 * Site controller
 */
class MemberController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return string
     */


    public function actionIndex()
    {
        //读数据
        $params = \Yii::$app->request->get();
        if(\Yii::$app->request->isAjax){
            $user = Member::search($params);
            return $this->convertJson('0','查询成功',$user['list'], $user['count']);
        }
        return $this->render('index');
    }
}