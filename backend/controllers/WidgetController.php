<?php
namespace backend\controllers;

use common\models\UserScope;
use common\models\UserScopeRecord;
use common\models\Widget;
use common\models\WidgetTag;
use common\models\WidgetTagJoin;
use common\models\WidgetType;
use Yii;
use yii\helpers\Json;
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
            $data = Widget::search($params);
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

                //添加用户积分记录
                $userScopeRecord = UserScopeRecord::findOne(['widget_id'=>$widget_id]);
                $widget_model = Widget::findOne(['id'=>$widget_id]);
                if($params['create_scope'] > 0){
                    if(!$userScopeRecord){
                        $userScopeRecord = new UserScopeRecord();
                        $userScopeRecord->u_id = $widget_model->u_id;
                        $userScopeRecord->scope = $params['create_scope'];
                        $userScopeRecord->widget_id = $widget_id;
                        $userScopeRecord->created_time = date("Y-m-d H:i:s",time());
                        $userScopeRecord->type = 1;
                        $userScopeRecord->save();
                    }else{
                        UserScope::insertUpdate($params['create_scope'],$widget_model->u_id);
                    }
                    //给用户添加积分
                    UserScope::insertUpdate($params['create_scope'],$widget_model->u_id);
                }


                if($widget_id){
                    Yii::$app->session['widget_create_id'] = $widget_id;
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！','id'=>$widget_id));
                }

                //生成视图地址
                $rootDir = '../../frontend/views/widget/'.$widget_id2;
                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                //生成静态文件地址
                $rootDir2 = '../../frontend/web/widget_file/'.$widget_id2;
                is_dir($rootDir2) OR mkdir($rootDir2, 0777, true);
                Yii::$app->session['widget_create_id'] = $widget_id2;
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','id'=>$widget_id2));
            };
        }

        //查询组件数据
        if($widget_id){
            $data['widget'] = Widget::find()->where(['id'=>$widget_id])->asArray()->one();
            if(!$data['widget']){
                return '组件不存在';
            }
            $scopeRecord = UserScopeRecord::findOne(['widget_id'=>$data['widget']['id']]);
            if($scopeRecord){
                $data['scope'] = $scopeRecord->scope;
            }else{
                $data['scope'] = 0;
            }
        }
//        var_dump($data);die;
        return $this->render('info',compact('data'));
    }

    //配置文件
    public function actionParams()
    {
        //读数据
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if(!$id) return 'ID不存在';
//        $dir = '../../frontend/web/widget_file/'.$id.'/';
//        $path = isset($_GET['dir']) ? $_GET['dir'] : $dir;
        //$result = $this->getDir($path);

        return $this->render('params',compact('result','path'));
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

            $rootDir = '../../frontend/web/widget_file/'.$id.'/';
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
                    if($zip == 'zip'){
                        $this->unZip($_FILES['file'],$rootDir);
                    }else{
                        $this->unRar($_FILES['file'],$rootDir);
                    }


                    $widget = Widget::findOne($id);
                    $widget->download = '/minWidget/' . $id . '/' . $name;
                    if($widget->save()){
                        return Json::encode(array('code'=>'100000','message'=>'上传成功！','data'=>array(
                            'name' => $name,
                            'download' => '/minWidget/'.$id.'/'.$name,
                        )));
                    }else{
                        return Json::encode(array('code'=>'100000','message'=>'图片上传成功，但并未保存到库中！','data'=>array(
                            'name' => $name,
                            'download' => '/minWidget/'.$id.'/'.$name,
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

    //更新组件
    public function actionUploadWidget(){

        if(Yii::$app->request->post()){
            $params = Yii::$app->request->post();
            $id = isset($params['id']) ? $params['id'] : '';
            if(!$params['id']){
                return Json::encode(array('code'=>'100001','message'=>'更新失败！'));
            };
            $uploadBeforeUrl = '../../frontend/web/upload_file/'.$id;
            $uploadAfterUrl = '../../frontend/web/widget_file/'.$id;
            //删除目录下的文件
            $this->deldir($uploadAfterUrl);
            rename($uploadBeforeUrl,$uploadAfterUrl);
            $model = Widget::findOne($id);
            $model->download = str_replace('upload_file','widget_file',$model->upload_download);
            $model->enter_file = $model->upload_enter_file;
            $model->upload_download = '';
            $model->upload_enter_file = '';
            if($model->save()){
                return Json::encode(array('code'=>'100000','message'=>'更新成功！','type'=>$model->attributes));
            }
            return Json::encode(array('code'=>'100001','message'=>'更新失败！'));
        }
    }

    public function unZip($fileSrc,$enterSrc){
        $zip = new \ZipArchive();//新建一个ZipArchive的对象
        if ($zip->open($fileSrc) === TRUE){

            $zip->extractTo($enterSrc);//假设解压缩到在当前路径下images文件夹的子文件夹php
            $zip->close();//关闭处理的zip文件
        }
    }

    //删除指定文件夹以及文件夹下的所有文件
    public function deldir($dir) {
        //先删除目录下的文件：
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
}