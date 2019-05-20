<?php
namespace backend\controllers;

use app\models\UploadForm;
use common\models\widget;
use common\models\widgetTag;
use common\models\widgetTagJoin;
use common\models\widgetType;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\LoginForm;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class WidgetController extends CommonController
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
            $data = widget::search($params);
            return $this->convertJson('0','查询成功',$data['list'], $data['count']);
        }
        return $this->render('index');
    }
    //创建文章
    public function actionInfo()
    {
        $widget_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存widgetModel数据
            $widget_id2 = widget::insertUpdate($params,$widget_id);
            if($widget_id2){
                if($widget_id){
                    Yii::$app->session['widget_create_id'] = $widget_id;
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！','id'=>$widget_id));
                }
                //生成视图地址
                $rootDir = '../../frontend/views/widget/'.$widget_id2;
                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                //生成静态文件地址
                $rootDir2 = '../../frontend/web/widget/'.$widget_id2;
                is_dir($rootDir2) OR mkdir($rootDir2, 0777, true);
                Yii::$app->session['widget_create_id'] = $widget_id2;
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','id'=>$widget_id2));
            };
        }

        //查询组件数据
        if($widget_id){
            $data['widget'] = widget::find()->where(['id'=>$widget_id])->asArray()->one();
            if(!$data['widget']){
                return '组件不存在';
            }
        }
//        var_dump($data);die;
        return $this->render('info',compact('data'));
        return $this->render('info');
    }

//    //设置为推荐
    public function actionRecommend(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 1 : 0;
        $widget = Widget::findOne($id);
        $widget->recommend = $checked;
        if($widget->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    //是否发布
    public function actionIssue(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 2 : 1;
        $widget = Widget::findOne($id);
        $widget->issue = $checked;
        if($widget->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    //是否允许下载
    public function actionIsDown(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 1 : 0;
        $widget = Widget::findOne($id);
        $widget->is_down = $checked;
        if($widget->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    public function actionDelete(){
        $widget_id = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $widget_id){
            Widget::deleteAll(['id'=>$widget_id]);
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

    public function actionUploadFile(){
        $model = new \common\models\UploadForm();
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->session['widget_create_id'];
            if(!$id){
                return Json::encode(array('code'=>'100001','message'=>'上传失败！'));
            }

            $rootDir = '../../frontend/web/widget/'.$id.'/';
            $model->file = UploadedFile::getInstanceByName('file');  //这个方式是js提交
            if ($model->file && $model->validate()) {
                $name = explode('.',$model->file->name);
                $zip = array_pop($name);
                //join('.',$name);

                //判断文件名中是否有中文
                if (preg_match("/[\x7f-\xff]/", $model->file->name)) {
                    $name = 'widget'.$id.'.'.$zip;
                }else{
                    $name = $model->file->name;
                }

                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                $fileSrc=$rootDir . $name;

                if($model->file->saveAs($fileSrc)){
                    //解压缩
//                    if($zip == 'zip'){
//                        $this->unZip($_FILES['file'],$rootDir);
//                    }else{
//                        $this->unRar($_FILES['file'],$rootDir);
//                    }


                    $widget = Widget::findOne($id);
                    $widget->download = '/widget/' . $id . '/' . $name;
                    if($widget->save()){
                        return Json::encode(array('code'=>'100000','message'=>'上传成功！','data'=>array(
                            'name' => $name,
                            'download' => '/widget/'.$id.'/'.$name,
                        )));
                    }else{
                        return Json::encode(array('code'=>'100000','message'=>'图片上传成功，但并未保存到库中！','data'=>array(
                            'name' => $name,
                            'download' => '/widget/'.$id.'/'.$name,
                        )));
                    }

                }
                return Json::encode(array('code'=>'100001','message'=>'上传失败！'));

            }
            return Json::encode(array('code'=>'100001','message'=>'上传失败！'));
        }
    }

    public function actionAddType(){

        if(Yii::$app->request->post()){
            $model = new WidgetType();
            $params = Yii::$app->request->post();
            $model->setAttributes($params);
            if($model->save()){
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','type'=>$model->attributes));
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }
        $data = WidgetType::find()->asArray()->all();
        return Json::encode(array('code'=>'100000','message'=>'查询成功！','data'=>$data));
    }
}