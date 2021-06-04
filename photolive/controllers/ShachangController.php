<?php
namespace photolive\controllers;
use photolive\models\LiJiashaStuffList;
use photolive\models\LiJiayouStuffList;
use yii\web\Controller;


//跨域访问的时候才会存在此字段
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
$allow_origin = array(
    'https://shachang.yu313.cn',
    'http://shachang.yu313.cn',
    'http://localhost:8080',
);
if(in_array($origin, $allow_origin)) {
    header('Access-Control-Allow-Origin:'.$origin);
    header('Access-Control-Allow-Methods:GET,HEAD,PUT,POST,DELETE,PATCH,OPTIONS');
    header('Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept,key,token');
}


/**
 * Site controller
 */
class ShachangController extends Controller
{
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
    public function actionLogin(){
        $params = \Yii::$app->request->post();
        var_dump($params['password'] == '000000');die;
        if($params['username'] == 'lipengfei' && $params['password'] == '000000'){
            return $this->convertJson('100000', '登录成功');
        }else{
            return $this->convertJson('100001', '登录失败，账号密码输入错误');
        }
    }
    /* 拉料列表 */
    public function actionLiaoList(){
        $date = \Yii::$app->request->post('date');
        if($date){
            $filter = ['like','daytime',$date];
        }else{
            $filter = [];
        }
        return LiJiashaStuffList::getList($filter);
    }

    /* 删除拉料数据 */
    public function actionDeleteLiao(){
        $params = \Yii::$app->request->post();
        return LiJiashaStuffList::deleteOne($params['id']);
    }

    /* 添加与修改数据*/
    public function actionLiaoInsertUpdate(){
        $params = \Yii::$app->request->post();
        $model = new LiJiashaStuffList();
        if($params['id']) {
            $message = '修改';
            $model = LiJiashaStuffList::findOne($params['id']);
            $params['updatetime'] = date('Y-m-d H:i:s',time());
        }else{
            $message = '添加';
            $params['createtime'] = date('Y-m-d H:i:s',time());
            $params['updatetime'] = date('Y-m-d H:i:s',time());
        }
        $model->setAttributes($params);
        if($model->save()){
            $result = $model->attributes;
            return self::convertJson('100000',$message.'成功',$result);
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001',$message.'失败');
        }
    }


    /* 拉料列表 油料*/
    public function actionYouLiaoList(){
        $date = \Yii::$app->request->post('date');
        if($date){
            $filter = ['like','daytime',$date];
        }else{
            $filter = [];
        }
        return LiJiayouStuffList::getList($filter);
    }

    /* 删除拉料数据 油料*/
    public function actionYouDeleteLiao(){
        $params = \Yii::$app->request->post();
        return LiJiayouStuffList::deleteOne($params['id']);
    }

    /* 添加与修改数据 油料*/
    public function actionYouLiaoInsertUpdate(){
        $params = \Yii::$app->request->post();
        $model = new LiJiayouStuffList();
        if($params['id']) {
            $message = '修改';
            $model = LiJiayouStuffList::findOne($params['id']);
            $params['updatetime'] = date('Y-m-d H:i:s',time());
        }else{
            $message = '添加';
            $params['createtime'] = date('Y-m-d H:i:s',time());
            $params['updatetime'] = date('Y-m-d H:i:s',time());
        }
        $model->setAttributes($params);
        if($model->save()){
            $result = $model->attributes;
            return self::convertJson('100000',$message.'成功',$result);
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001',$message.'失败');
        }
    }

    /* 拉料与油料统计 */
    public function actionLiaoYouCount(){
        $year = date('Y');
        $month = date('Y-m');

        /* 料 */
        $liaoYearData = LiJiashaStuffList::find()->andWhere(['like','daytime',$year])->asArray()->all();
        $liaoMonthData = LiJiashaStuffList::find()->andWhere(['like','daytime',$month])->asArray()->all();
        $liaoCountData = LiJiashaStuffList::find()->asArray()->all();

        /* 油 */
        $youYearData = LiJiayouStuffList::find()->andWhere(['like','daytime',$year])->asArray()->all();
        $youMonthData = LiJiayouStuffList::find()->andWhere(['like','daytime',$month])->asArray()->all();
        $youCountData = LiJiayouStuffList::find()->asArray()->all();
        /* 料 */
        $liaoYearXsCount = 0;
        $liaoYearLgCount = 0;
        foreach ($liaoYearData as $item) {
            $liaoYearXsCount += floatval($item['xs_car']);
            $liaoYearLgCount += floatval($item['lg_car']);
        }
        $liaoMonthXsCount = 0;
        $liaoMonthLgCount = 0;
        foreach ($liaoMonthData as $item) {
            $liaoMonthXsCount += floatval($item['xs_car']);
            $liaoMonthLgCount += floatval($item['lg_car']);
        }
        $liaoCountDataXsCount = 0;
        $liaoCountDataLgCount = 0;
        foreach ($liaoCountData as $item) {
            $liaoCountDataXsCount += floatval($item['xs_car']);
            $liaoCountDataLgCount += floatval($item['lg_car']);
        }
        /* 油 */
        $youYearCount = 0;
        foreach ($youYearData as $item) {
            $youYearCount += floatval($item['total']);
        }
        $youMonthCount = 0;
        foreach ($youMonthData as $item) {
            $youMonthCount += floatval($item['total']);
        }
        $youCountDataCount = 0;
        foreach ($youCountData as $item) {
            $youCountDataCount += floatval($item['total']);
        }
        $data = array(
            'liaoYearXsCount' => $liaoYearXsCount,
            'liaoYearLgCount' => $liaoYearLgCount,
            'liaoMonthXsCount' => $liaoMonthXsCount,
            'liaoMonthLgCount' => $liaoMonthLgCount,
            'liaoCountDataXsCount' => $liaoCountDataXsCount,
            'liaoCountDataLgCount' => $liaoCountDataLgCount,
            'youYearCount' =>$youYearCount,
            'youMonthCount'=>$youMonthCount,
            'youCountDataCount' => $youCountDataCount,
        );
        return self::convertJson('100000','获取成功',$data);
    }

}