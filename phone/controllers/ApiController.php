<?php

namespace phone\controllers;

use phone\models\TelContact;
use phone\models\TelList;
use phone\models\TelLunbo;
use phone\models\TelNav;
use yii\web\Controller;

header("Access-Control-Allow-Origin: *");

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
        $Json['msg'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);

    }

    public function getOnline(){
        return array(
            array('id' => '1','title' =>  '移动网络'),
            array('id' => '2','title' =>  '联通网络'),
            array('id' => '3','title' =>  '电信网络'),
        );
    }

    /* 获取首页数据 */
    public function actionIndex(){
        //读数据

        /* 轮播 */
        $banner = TelLunbo::find()->asArray()->all();

        /* 导航 */
        $nav = TelNav::find()->where(['is_recommend'=>1])->orderBy(['sort'=>SORT_DESC])->asArray()->all();

        /* 推荐列表 */
        $recommend = TelList::find()->joinWith('userInfo')->where(['is_recommend'=>1])->limit(20)->asArray()->all();

        /* 最新列表 */
        $news = TelList::find()->joinWith('userInfo')->orderBy(['id'=>SORT_DESC])->limit(20)->asArray()->all();
        $data = [
            'banner' => $banner,
            'nav'    => $nav,
            'recommend' => $recommend,
            'news'   => $news,
            'online' => $this->getOnline(),
            'site_url' => \Yii::$app->params['backend_url'],
        ];
        return $this->convertJson('200','查询成功',$data,0);
    }

    /* 获取联系人数据 */
    public function actionUserList(){
        /* 最新列表 */
        $contact = TelContact::find()->asArray()->all();
        return $this->convertJson('200','查询成功',$contact,0);
    }

    /* 获取筛选条件数据 */
    public function actionGetFilter(){
        //读数据
        $params = \Yii::$app->request->get();
        $nav = TelNav::find()->orderBy(['sort'=>SORT_DESC])->asArray()->all();
        $price = array(
            array("id"=>'DESC',"title"=> "价格由高到低"),
            array("id"=>'ACE',"title"=> "价格由低到高"),
            array("id"=>'0-99',"title"=>"0~99"),
            array("id"=>'100-499',"title"=>"100~499"),
            array("id"=>'500-999',"title"=>"500~999"),
            array("id"=>'1000-4999',"title"=>"1000~4999"),
            array("id"=>'5000-9999',"title"=>"5000~9999"),
            array("id"=>'10000-49999',"title"=>"10000~49999"),
            array("id"=>'50000-',"title"=>"50000以上"),
        );
        $data = [
            'online' => $this->getOnline(),
            'nav' => $nav,
            'price' => $price,
        ];
        return $this->convertJson('200','查询成功',$data, 0);
    }

    /* 获取号码列表 */
    public function actionSelectTel(){
        //读数据
        $params = \Yii::$app->request->get();
        $numberList = TelList::search($params);
        $data = array('data'=>$numberList['data'],'count'=>$numberList['count']);
        return $this->convertJson('200','查询成功',$data, 0);
    }
}