<?php

namespace photolive\controllers;


use photolive\models\LoginForm;
use photolive\models\PhotoGroup;
use photolive\models\PhotoList;
use photolive\models\PhotoType;
use photolive\models\SignupForm;
use photolive\models\User;
use yii\web\Controller;

class ApiController extends Controller
{

    /**转Json格式
     * @param $code
     * @param $message
     * @param $data
     * @param $count
     * @return string
     */
    public function convertJson($code, $message, $data = '', $count = null)
    {

        $Json['code'] = $code;
        $Json['message'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);

    }

    /**
     * 用户登录  \\ 前台与后台同步登录
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post(),'')) { //载入post所获取的数据
            if ($user = $model->loginup()) {
                return $this->convertJson('100000','登录成功', $user->attributes);
            }else{
                if ($user->errors) {
                    foreach ($user->errors as $val) {
                        return $this->convertJson('100001', $val[0]);
                    }
                }else{
                    return $this->convertJson('100001', '登录失败');
                }
            }
        };
    }

    /**
     * 用户注册 \\ 前台与后台同步登录
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post(),'')) { //载入post所获取的数据
            if ($user = $model->signup()) {
                if (\Yii::$app->getUser()->login($user,3600*24*7)) {
                    //return $this->goHome();
                    $id = $user->id;
                    $one = User::find()->where(['id' => $id])->select(['id','username','sex','province_id','city_id','area_id','phone'])->asArray()->one();
                    return $this->convertJson('100000', '注册成功',$one);
                }
            }else{
                if ($user->errors) {
                    foreach ($user->errors as $val) {
                        return $this->convertJson('100001', $val[0]);
                    }
                }
                return $this->convertJson('100001', '注册失败');

            }
        };
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

        return $this->convertJson('100000', '获取成功',$data);

    }

    /**
     * 获取相册类型
     */
    public function actionPhotoType()
    {
        return PhotoType::getList();
    }

    /**
     * 获取相册列表
     */
    public function actionPhotoList()
    {
        $params = \Yii::$app->request->post();
        return PhotoList::getList(['u_id'=>$params['u_id']]);
    }

    /**
     * 创建与更新相册
     */
    public function actionCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        return PhotoList::insertUpdate($params);
    }

    /**
     * 删除相册
     */
    public function actionPhotoRemove(){
        $id = \Yii::$app->request->post('id');
        return PhotoList::deleteOne($id);
    }

    /**
     * 创建与更新相册分组
     */
    public function actionPhotoGroupCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        return PhotoGroup::insertUpdate($params);
    }
    /**
     * 删除相册分组
     */
    public function actionPhotoGroupRemove()
    {
        $id = \Yii::$app->request->post('id');
        return PhotoGroup::deleteOne($id);
    }
    /**
     * 获取分组列表
     */
    public function actionPhotoGroupList()
    {
        $params = \Yii::$app->request->post();
        $result = PhotoGroup::find()->where(['project_id'=>$params['project_id']])->orderBy(['sort' => SORT_ACE])->asArray()->all();
        return self::convertJson('100000','查询成功',$result);
    }
    /**
     * 分组排序
     */
    public function actionPhotoGroupSort()
    {
        $params = \Yii::$app->request->post();
        foreach ($params as $key => $val) {
            $model = new PhotoGroup();
            $model->updateAll(['sort'=>$val['sort']],['id'=>$val['id']]);
        }
        if ($model->getFirstErrors()) {
            foreach ($model->getFirstErrors() as $val) {
                return self::convertJson('100001', $val);
            }
        }
        return self::convertJson('100000','修改成功');
    }

}