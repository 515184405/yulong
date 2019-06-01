<?php
namespace frontend\controllers;


use common\models\MadeToOrder;
use common\models\Widget;
use common\models\WidgetType;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class UserController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $uid = 0;
        $params = Yii::$app->request->get();
        $status = isset($params['status']) ? $params['status'] : 1;
        $widget = Widget::find()->select(['id','title','desc','banner_url','look','fail_msg','collect','down_count','status'])->where(['status'=>$status,'u_id'=>$uid])->asArray()->all();
        $data = [
            'widget'=>$widget,
        ];
        return $this->render('index',compact('data'));
    }

    //按分类取组件
    public function limitPage($params,$condition){
        /*按分类取组件*/
        $uid = 0;
        $type_id = isset($params['type']) ? $params['type'] : '';
        $type_id = $type_id != 0 ? $type_id : '';
        $widgetData = Widget::find()->select(['id','title','desc','banner_url','type','look','collect','down_count','download','status'])->where($condition)->asArray()->all();
        $limit = 20; //每页显示20条
        $page = isset($params['page']) ? $params['page'] : 1;
        $unit = [];
        $is_true = false; //判断当前类型是否存在项目
        foreach ($widgetData as $item) {
            $is_true = false;
            foreach (explode(',',$item['type']) as $type) {
                if($type == $type_id && $is_true !== true){
                    $is_true = true; //当前类型中存在项目
                }
            }
            if($type_id) {
                if ($is_true) {
                    array_push($unit, $item);
                }
            }else{
                array_push($unit, $item);
            }
        }
        $pagination = new Pagination(['totalCount' => count($unit),'pageSize' => $limit]);
        $unit = array_slice($unit,$limit*($page-1),$limit);
        $data = [
            'pagination' => $pagination,
            'unit' => $unit,
        ];
        return compact('data');
    }

    //取所有收藏的所有分类
    public function collectType($condition){
        //取分类
        $uid = 0;
        $typeArr = [];
        $widget = Widget::find()->select(['type'])->where($condition)->asArray()->all();
        $typeArr[0] = array('title'=>'全部分类','number'=>count($widget));
        foreach ($widget as $item) {
            foreach (explode(',',$item['type']) as $type){
                $widgetType = WidgetType::findOne(['type_id'=>$type]);
                if(isset($typeArr[$widgetType->type_id])){
                    $typeArr[$widgetType->type_id]['number'] += 1;
                }else{
                    $typeArr[$widgetType->type_id] = array('title'=>$widgetType->title,'number'=>1);
                }
            }
        }
        return compact('typeArr');
    }

    //我的收藏
    public function actionCollect()
    {
        $uid = 0;
        $params = Yii::$app->request->get();
        //取所有分类
        $collectTypeData = $this->collectType(['u_id'=>$uid,'status'=>1]);
        //取所有组件
        $limitPageData = $this->limitPage($params,['u_id'=>$uid,'status'=>1]);
        $data = [
            'widget'=>$limitPageData['data']['unit'],
            'typeArr'=>$collectTypeData['typeArr'],
            'pagination' => $limitPageData['data']['pagination'],
        ];
        return $this->render('collect',compact('data'));
    }

    //上传或者修改
    public function actionInfo()
    {
        $widget_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存widgetModel数据
            $widget_id2 = Widget::insertUpdate($params,$widget_id);
            if($widget_id2){
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
            $data['widget'] = widget::find()->where(['id'=>$widget_id])->asArray()->one();
            if(!$data['widget']){
                return '组件不存在';
            }
        }
//        var_dump($data);die;
        return $this->render('info',compact('data'));
    }

    //下载历史
    public function actionDownHistory()
    {
        $uid = 0;
        $params = Yii::$app->request->get();
        //取所有分类
        $collectTypeData = $this->collectType(['u_id'=>$uid,'status'=>1]);
        //取所有组件
        $limitPageData = $this->limitPage($params,['u_id'=>$uid,'status'=>1]);
        $data = [
            'widget'=>$limitPageData['data']['unit'],
            'typeArr'=>$collectTypeData['typeArr'],
            'pagination' => $limitPageData['data']['pagination'],
        ];
        return $this->render('down-history',compact('data'));
    }

    //组件定制
    public function actionDingzhi()
    {
        $uid = 0;
        $params = Yii::$app->request->get();
        $status = isset($params['status']) ? $params['status'] : 2;
        if($status == 2){
            $widget = MadeToOrder::find()->joinWith(['project_join'])->select(['widget_id','made_to_order.status'])->where(['made_to_order.status'=>$status,'made_to_order.u_id'=>$uid])->asArray()->all();
        }else{
            $widget = MadeToOrder::find()->where(['status'=>$status])->asArray()->all();
        }
        $data = [
            'widget'=>$widget,
        ];
//        var_dump($widget);die;
        return $this->render('dingzhi',compact('data'));
    }

    //信息通知
    public function actionMessage()
    {
        $uid = 0;
        $params = Yii::$app->request->get();
        $status = isset($params['status']) ? $params['status'] : 1;
        $widget = Widget::find()->select(['id','title','desc','banner_url','look','fail_msg','collect','down_count','status'])->where(['status'=>$status,'u_id'=>$uid])->asArray()->all();
        $data = [
            'widget'=>$widget,
        ];
        return $this->render('message',compact('data'));
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
//                    if($zip == 'zip'){
//                        $this->unZip($_FILES['file'],$rootDir);
//                    }else{
//                        $this->unRar($_FILES['file'],$rootDir);
//                    }


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
}
