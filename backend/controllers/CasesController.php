<?php
namespace backend\controllers;

use common\models\Cases;
use common\models\CaseTag;
use common\models\CaseTagJoin;
use common\models\CaseType;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Site controller
 */
class CasesController extends CommonController
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
//    public function actionInfo()
//    {
//        $case_id = isset($_GET['id']) ? $_GET['id'] : '';
//        //存数据
//        if (Yii::$app->request->isPost) {
//
//            $params = $_POST;
//            $params['create_time'] = time();
//            $caseTag = new CaseTag();
//            $casesModel = new Cases();
//            $caseTagArr = explode(',',$params['tag_id']);
//            if(!empty($case_id)) {
//                $casesModel = $casesModel::findOne($case_id);
//            }
//            $casesModel->setAttributes($params);
//            $tagStr = '';
//            if($casesModel->save()){
//                $casesModel::find()->where(['id'=>$casesModel->attributes['id']])->one();
//                //存标签并更新案例关联标签
//                $casesModel->tag_id = $caseTag->insetData($caseTagArr);
//                $casesModel->save();
//
//                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
//            }
//            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
//        }
//
//        //读数据
//        $caseType = new CaseType();
//        $data['case_type'] = $caseType::find()->asArray()->all();
//        if(!empty($case_id)){
//            $case = new Cases();
//            $data['case'] = $case::find()->joinWith('tag_id')->where(['id'=>$case_id])->asArray()->one();
//        }
//        return $this->render('info',compact('data'));
//    }



    //创建案例
    public function actionInfo()
    {
        $case_id = isset($_GET['id']) ? $_GET['id'] : '';
        //存数据
        if (Yii::$app->request->isPost) {

            $params = $_POST;
            //存或更新cases表;
            $casesModel = new Cases();
            $cases_id = $casesModel->insertUpdate($params,$case_id);
            //存或更新caseTag表
            $caseTagModel = new CaseTag();
            $caseTagArr = explode(',',$params['tag_id']);
            $caseTag_id = $caseTagModel->insertUpdate($caseTagArr);
            //存或更新caseTagJoin表
            $CaseTagJoinModel = new CaseTagJoin();
            $CaseTagJoinModel->insertUpdate($cases_id,$caseTag_id);
            if($caseTag_id && $cases_id){
                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }

        //读数据
        $caseType = new CaseType();
        $data['case_type'] = $caseType::find()->asArray()->all();
        if(!empty($case_id)){
            $cases = new Cases();
            $data['case'] = $cases::find()->joinWith(['tag_join'])->where(['Cases.id'=>$case_id])->asArray()->one();
        }
        return $this->render('info',compact('data'));
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