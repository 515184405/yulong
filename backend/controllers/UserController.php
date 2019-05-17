<?php
namespace backend\controllers;
use common\models\User;
use yii\helpers\Json;


/**
 * Site controller
 */
class UserController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(\Yii::$app->request->isPost){
            $params = \Yii::$app->request->post();
            $params['created_time'] = time();
            $params['login_time'] = time();
            $params['updated_time'] = time();
            $params['login_ip'] = $_SERVER["REMOTE_ADDR"];
            $params['type'] = 2;
            $user = new User();
            $user->setAttributes($params);
            if($user->save()){
                return Json::encode(array('code'=>100000,'message'=>'添加成功'));
            }
            return Json::encode(array('code'=>100001,'message'=>'添加失败'));
        }
        if(\Yii::$app->view->params['userInfo']['type'] == 2){
            return '您还不是超级管理员';
        }
        return $this->render('index');
    }
}