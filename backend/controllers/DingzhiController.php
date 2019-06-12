<?php
namespace backend\controllers;

use common\models\Banner;
use common\models\MadeToOrder;
use Yii;
use yii\helpers\Json;

/**
 * Site controller
 */
class DingzhiController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //读数据
        $params = Yii::$app->request->get();
        if(Yii::$app->request->isAjax){
            $data = MadeToOrder::search($params);
            return $this->convertJson('0','查询成功',$data['data'], $data['count']);
        }
        return $this->render('index');
    }

    public function actionDelete(){
        $dingzhi_id = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $dingzhi_id){
            MadeToOrder::deleteAll(['id'=>$dingzhi_id]);
            return Json::encode(['code' => 100000,'message' => '删除成功']);
        }else{
            return Json::encode(['code' => 100000,'message'=> '没有找到要删除的目标']);
        }
    }

    public function actionInfo()
    {
        $dingzhi_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(\Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            $dingzhi_id2 = MadeToOrder::insertUpdate($params,$dingzhi_id);
            if($dingzhi_id2){
                if($dingzhi_id){
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
                }
                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }
        //查询banner数据
        if($dingzhi_id){
            $data = MadeToOrder::find()->where(['id'=>$dingzhi_id])->asArray()->one();
            if(!$data){
                return '定制组件不存在';
            }
        }
        return $this->renderPartial('info',compact('data'));
    }
}