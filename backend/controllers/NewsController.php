<?php
namespace backend\controllers;

use common\models\NewsType;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\LoginForm;

/**
 * Site controller
 */
class NewsController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    //创建文章
    public function actionInfo()
    {
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            var_dump($params);die;
        }
        //查类型数据
        $data['type'] = NewsType::find()->asArray()->all();
        return $this->render('info',compact('data'));
    }
    //新增文章类型
    public function actionType()
    {
        $data = '';
        if(Yii::$app->request->isAjax) {
            $model = new NewsType();
            //获取POST内容
            $params = Yii::$app->request->post();
            $model->setAttributes($params);
            if($model->save()){
                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
        }
        return $this->render('type');
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