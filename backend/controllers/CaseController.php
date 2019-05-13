<?php
namespace backend\controllers;

use common\models\Cases;
use common\models\CaseTag;
use common\models\CaseType;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

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
        if (Yii::$app->request->isPost) {

            $params = ($_POST);
            $params['create_time'] = time();
            $casesModel = new Cases();
            $caseTag = new CaseTag();
            $caseTagArr = explode(',',$params['tag_id']);
            $casesModel->setAttributes($params);
            $tagStr = '';
            if($casesModel->save()){

                $casesModel::find()->where(['id'=>$casesModel->attributes['id']])->one();
                //存标签并更新案例关联标签
                $casesModel->tag_id = $caseTag->insetData($caseTagArr,$casesModel->attributes['id']);
                $casesModel->save();

                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));

        }

        return $this->render('info');
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

    //编辑器图片上传
    public function actionLayedit(){
        $uploadImage = $this->uploadImage();
        if(isset($uploadImage)){
            if($uploadImage['status']) {
                return Json::encode(array('code'=>'0','msg'=>'添加成功！','data'=>array(
                    'title' => $uploadImage['fileName'],
                    'src' => '/'.$uploadImage['fileSrc']
                )));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
        }
    }

    //删除图片文件
    public function actionRemoveImage(){
        $fileSrc = isset($_POST['filesrc']) ? $_POST['filesrc'] : '';
        if($fileSrc){
            unlink(substr($fileSrc,1));
            return Json::encode(array('code'=>'100000','message'=>'删除成功！'));
        }
        return Json::encode(array('code'=>'100001','message'=>'删除失败！'));
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