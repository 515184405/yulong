<?php
namespace photolive\controllers;

use common\models\News;
use common\models\NewsTag;
use common\models\NewsTagJoin;
use common\models\NewsType;
use photolive\models\Goods;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\LoginForm;

/**
 * Site controller
 */
class GoodsController extends CommonController
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
            $data = Goods::search($params);
            return $this->convertJson('0','查询成功',$data['data'], $data['count']);
        }
        return $this->render('index');
    }
    //创建商品
    //创建banner
    public function actionInfo()
    {
        $good_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            $good_id2 = Goods::insertUpdate($params,$good_id);
            if($good_id2){
                if($good_id){
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
                }
                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }
        //查询banner数据
        if($good_id){
            $data['goods'] = Goods::find()->where(['id'=>$good_id])->asArray()->one();
            if(!$data['goods']){
                return '轮播图不存在';
            }
        }
        return $this->render('info',compact('data'));
    }

    //设置为推荐
    public function actionRecommend(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 1 : 0;
        $good = Goods::findOne($id);
        $good->recommend = $checked;
        if($good->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    //设置为发布状态
    public function actionIssue(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 1 : 0;
        $good = Goods::findOne($id);
        $good->status = $checked;
        if($good->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    public function actionDelete(){
        $goodid = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $goodid){
            Goods::deletes($goodid);
            return Json::encode(['code' => 100000,'message' => '删除成功']);
        }else{
            return Json::encode(['code' => 100000,'message'=> '没有找到要删除的目标']);
        }
    }

    //图片上传
    public function actionUploadImage(){
        $uploadImage = $this->uploadImage();
        if(isset($uploadImage)){
            if($uploadImage['status']) {
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','data'=>array(
                    'fileName' => $uploadImage['fileName'],
                    'fileSrc' => '/'.$uploadImage['fileSrc']
                )));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
        }
    }
}