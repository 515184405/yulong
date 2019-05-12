<?php
namespace backend\controllers;

use common\models\CaseType;
use common\models\UploadForm;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class CaseController extends CommonController
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

    //创建案例
    public function actionInfo()
    {
        return $this->UploadImageFile();
    }

    //上传图片
    public function UploadImageFile(){

        return $this->render('info');
    }

    //添加案例类型
    public function actionType()
    {
        $data = '';
        if(Yii::$app->request->isAjax) {
            $model = new CaseType();
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
}