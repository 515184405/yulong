<?php

namespace photolive\controllers;


use common\models\UploadForm;
use photolive\models\LoginForm;
use photolive\models\PhotoCoverSettings;
use photolive\models\PhotoGroupSettings;
use photolive\models\PhotoList;
use photolive\models\PhotoTopShareSettings;
use photolive\models\PhotoType;
use photolive\models\PhotoWaterArray;
use photolive\models\PhotoWaterSettings;
use photolive\models\PhotoWxShareSettings;
use photolive\models\PictureList;
use photolive\models\PyList;
use photolive\models\SignupForm;
use photolive\models\User;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ApiController extends TokenController
{

    /**
     * 用户登录  \\ 前台与后台同步登录
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post(), '')) { //载入post所获取的数据
            if ($user = $model->loginup()) {
                $token = $this->actionCreateToken($user->attributes['id']);
                $one = array(
                    'id' => $user->attributes['id'],
                    'username' => $user->attributes['username'],
                    'sex' => $user->attributes['sex'],
                    'province_id' => $user->attributes['province_id'],
                    'city_id' => $user->attributes['city_id'],
                    'area_id' => $user->attributes['area_id'],
                    'phone' => $user->attributes['phone'],
                    'token' => $token,
                );
                #调取Token生成方法[传递参数用户UID]
                return $this->convertJson('100000', '登录成功', $one);
            } else {
                if ($model->getFirstErrors()) {
                    foreach ($model->getFirstErrors() as $val) {
                        return $this->convertJson('100001', $val);
                    }
                }
            }
        }
        return $this->convertJson('100001', '登录失败');
    }

    /**
     * 用户注册 \\ 前台与后台同步登录
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post(), '')) { //载入post所获取的数据
            $user = $model->signup();
            if ($user) {
                // 半天后过期
                if (\Yii::$app->getUser()->login($user, 3600 * 12)) {
                    //return $this->goHome();
                    $id = $user->id;
                    $one = User::find()->where(['id' => $id])->select(['id', 'username', 'sex', 'province_id', 'city_id', 'area_id', 'phone'])->asArray()->one();
                    $token = $this->actionCreateToken($one['id']);
                    $one['token'] = $token;
                    return $this->convertJson('100000', '注册成功', $one);
                }
            } else {
                if ($model->getFirstErrors()) {
                    foreach ($model->getFirstErrors() as $val) {
                        return $this->convertJson('100001', $val);
                    }
                }
            }
            return $this->convertJson('100001', '注册失败');
        }
    }

    /**
     * 前后台同步退出 \\ 前台与后台同步退出
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->convertJson('100000', '成功退出');

    }

    /**
     * 获取省市区
     */
    public function actionGetCitys()
    {
        $json_string = file_get_contents('../web/json/china.json');

        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);

        return $this->convertJson('100000', '获取成功', $data);

    }

    /**
     * 获取相册类型
     */
    public function actionPhotoType()
    {
        return PhotoType::getList();
    }





    /**************************************************  以上为个人中心部分 ******************************************************/


    /**************************************************  以下为网站信息部分 ******************************************************/

    /**
     * 获取相册列表
     */
    public function actionCaseList()
    {
        $params = \Yii::$app->request->post();
        $query = PhotoList::find()->where(['status' => 1]);
        //按name查找
        if (isset($params['name'])) {
            $query->andFilterWhere(['like', 'name', $params['name']]);
        }
        //按type查找
        if (isset($params['type']) && $params['type'] != '0') {
            $query->andFilterWhere(['type_id' => $params['type']]);
        }
        //按时间查找
        if (isset($params['starttime']) && isset($params['endtime'])) {
            $query->andFilterWhere(['and', ['>=', 'starttime', $params['starttime']], ['<=', 'endtime', $params['endtime']]]);
        }
        //按地点查找
        if (isset($params['province_id']) && isset($params['city_id']) && isset($params['area_id'])) {
            $query->andFilterWhere(['and', 'province_id=' . $params['province_id'], ['and', 'city_id=' . $params['city_id'], 'area_id=' . $params['area_id']]]);
        }
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 50;
        $count = 0;
        if ($page && $limit) {
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        //$list = $query->joinWith('caseType')->orderBy(['id' => SORT_DESC])->asArray()->all();
        $list = $query->orderBy(['id' => SORT_DESC])->asArray()->all();
        return self::convertJson(100000, '查询成功', $list, $count);
    }

    /**
     * 获取相册详情
     */
    public function actionCaseDetail()
    {
        $params = \Yii::$app->request->post();
        $query = PictureList::find();
        if (!$params['project_id']) {
            return self::convertJson(100001, '项目不存在');
        }
        $query->where(['project_id' => $params['project_id']]);
        if (isset($params) && $params['groupId'] != 0) {
            $query->andFilterWhere(['groupId' => $params['groupId']]);
        }
        if (isset($params) && $params['type'] !== '0') {
            $query->orderBy([$params['type'] => SORT_DESC]);
        } else {
            $query->orderBy(['id' => SORT_DESC]);
        }
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 50;
        $count = 0;
        if ($page && $limit) {
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->asArray()->all();
        return self::convertJson(100000, '查询成功', $list, $count);
    }

    /**
     * 收藏功能
     */
    /*public function actionCollect(){
        $params = \Yii::$app->request->post();
        if(!$params['u_id']){

        }
    }*/


}