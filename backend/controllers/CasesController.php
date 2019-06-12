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
        //读数据
        $params = Yii::$app->request->get();
        if(Yii::$app->request->isAjax){
            $data = Cases::search($params);
            return $this->convertJson('0','查询成功',$data['list'], $data['count']);
        }
        return $this->render('index');
    }

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
            if(!$caseTag_id){
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
            //存或更新caseTagJoin表
            $CaseTagJoinModel = new CaseTagJoin();
            $CaseTagJoinModel->insertUpdate($cases_id,$caseTag_id);
            if($case_id){
                return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
            }
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
            $data['case'] = $cases::find()->joinWith(['tag_join'])->where(['cases.id'=>$case_id])->asArray()->one();
            if(empty($data['case'])){
                return '此项目不存在';
            }
        }
        return $this->render('info',compact('data'));
    }

    public function actionDelete(){
        $caseid = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $caseid){
            Cases::deletes($caseid);
            CaseTagJoin::deletes($caseid);
            return Json::encode(['code' => 100000,'message' => '删除成功']);
        }else{
            return Json::encode(['code' => 100000,'message'=> '没有找到要删除的目标']);
        }
    }

    //设置为推荐
    public function actionRecommend(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 1 : 0;
        $cases = Cases::findOne($id);
        $cases->recommend = $checked;
        if($cases->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
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