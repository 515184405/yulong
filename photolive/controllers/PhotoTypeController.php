<?php
namespace photolive\controllers;

use photolive\models\PhotoType;
use Yii;
use yii\helpers\Json;

/**
 * Site controller
 */
class PhotoTypeController extends CommonController
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
            $query = PhotoType::find();
            $limit = isset($params['limit']) ? $params['limit'] :'';
            $page = isset($params['page']) ? $params['page'] :'';
            $count = 0;
            if($limit && $page){
                $offset = $limit * ($page - 1);
                $count = $query->count();
                $query->offset($offset)->limit($limit);
            }
            $data = $query->orderBy(['id'=>SORT_ASC])->asArray()->all();
            return $this->convertJson('0','查询成功',$data, $data['count']);
        }
        return $this->render('index');
    }
    //创建banner
    public function actionInfo()
    {
        $photo_type_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(Yii::$app->request->isPost){
            $params = Yii::$app->request->post();
            $model = new PhotoType();
            if($photo_type_id){
                $model = $model::findOne($photo_type_id);
            }else{
                $params['createtime'] = date('Y-m-d H:i:s',time());
            }
            $model->setAttributes($params);
            if($model->save()){
                if(!$photo_type_id) {
                    return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
                }
                return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
            };
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }
        //查询banner数据
        if($photo_type_id){
            $data = PhotoType::find()->where(['id'=>$photo_type_id])->asArray()->one();
            if(!$data){
                return '场景不存在';
            }
        }
        return $this->render('info',compact('data'));
    }

    public function actionDelete(){
        $photo_type_id = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $photo_type_id){
            PhotoType::deleteAll(['id'=>$photo_type_id]);
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