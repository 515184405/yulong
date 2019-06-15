<?php
namespace frontend\controllers;


use common\models\MadeToOrder;
use common\models\UserCollect;
use common\models\UserDownRecord;
use common\models\UserGuanzhu;
use common\models\UserSign;
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

    public function beforeAction($action)
    {
        //如果未登录，则直接返回
        if(Yii::$app->user->isGuest){
            return $this->redirect('/site/login');
        }

        return true;

    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function init()
    {
        //签到信息
        $user_id = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $sign = UserSign::find()->where(['u_id'=>$user_id])->asArray()->one();
        Yii::$app->view->params['sign'] = $sign;
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $uid = 0;
        $params = Yii::$app->request->get();
        $status = isset($params['status']) ? $params['status'] : 1;
        $limit =20; //每页显示20条
        $page = isset($params['page']) ? $params['page'] : 1;
        $widget = Widget::find()->select(['id','title','desc','banner_url','look','fail_msg','collect','down_count','status'])->where(['status'=>$status,'u_id'=>$uid]);
        $pagination = new Pagination(['totalCount' => $widget->count(),'pageSize' => $limit]);
        $widget = $widget->offset(($page-1)*$limit)->limit($limit)->asArray()->all();
        $data = [
            'widget'=>$widget,
            'pagination' => $pagination
        ];
        return $this->render('index',compact('data'));
    }

    //按分类取组件
    public function limitPage($params,$condition){
        /*按分类取组件*/
        $uid = 0;
        $type_id = isset($params['type']) ? $params['type'] : '';
        $type_id = $type_id != 0 ? $type_id : '';
        $widgetData = UserCollect::find()->joinWith('collect_widget')->where($condition)->asArray()->all();
        $limit = 20; //每页显示20条
        $page = isset($params['page']) ? $params['page'] : 1;
        $unit = [];
        $is_true = false; //判断当前类型是否存在项目
        foreach ($widgetData as $item) {
            $is_true = false;
            foreach (explode(',',$item['collect_widget']['type']) as $type) {
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
        $widget = UserCollect::find()->joinWith('collect_widget')->where($condition)->asArray()->all();
        $typeArr[0] = array('title'=>'全部分类','number'=>count($widget));
        foreach ($widget as $item) {
            foreach (explode(',',$item['collect_widget']['type']) as $type){
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
        $collectTypeData = $this->collectType(['user_collect.u_id'=>$uid,'widget.status'=>1]);
        //取所有组件
        $limitPageData = $this->limitPage($params,['user_collect.u_id'=>$uid,'widget.status'=>1]);
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
        $limit =20; //每页显示20条
        $page = isset($params['page']) ? $params['page'] : 1;
        $user_down_record = UserDownRecord::find()->where(['u_id'=>$uid]);
        $pagination = new Pagination(['totalCount' => $user_down_record->count(),'pageSize' => $limit]);
        $user_down_record = $user_down_record->offset(($page-1)*$limit)->limit($limit)->asArray()->all();
        $data = [
            'record'=>$user_down_record,
            'pagination' => $pagination
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

    //我的关注
    public function actionGuanZhu()
    {
        $uid = 0;
        $guanZhu = UserGuanzhu::find()->where(['u_id'=>$uid])->asArray()->all();
        $data = [
            'guanZhu'=>$guanZhu,
        ];
        return $this->render('guan-zhu',compact('data'));
    }

    //用户签到
    public function actionSign(){
        $params = [];
        $u_id = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $signModel = UserSign::findOne(['u_id'=>$u_id]);
        //如何不存在此用户 则增加数据
        if(!$signModel){
            $params['last_change_time'] = date("Y-m-d H:i:s",time());
            $params['sign_history'] = strval(date("Y-m-d H:i:s",time()));
            $params['sign_count'] = 1;
            $params['count'] = 1;
            $params['u_id'] = $u_id;
            $params['score'] = 0;
            $signModel = new UserSign();
        }else{
            //存在修改值
            $nowDate = getdate(time());
            //当前用户上次签到时间
            $last_time = getdate(strtotime($signModel->last_change_time));

            //如果不是同一天
            if($this->isDiffDays($last_time,$nowDate)){
                if($this->isStreakDays($last_time,$nowDate)){
                    $signModel->sign_count += 1; //连续签到次数
                    if($signModel->sign_count >= 3){
                        $signModel->score += 1;
                    }
                }else{
                    $signModel->sign_count = 1; //连续签到次数
                }
                $signModel->count += 1; //签到数加1
                $signModel->sign_history = ($signModel->last_change_time).",".strval(date("Y-m-d H:i:s",time())); //签到历史时间
                $signModel->last_change_time = date("Y-m-d H:i:s",time()); //最后一次时间改成当前时间

            }else{
                return Json::encode(array('code'=>'100001','message'=>'今天您已签到'));
            }
        }
        $signModel->setAttributes($params);
        if($signModel->save()){
            return Json::encode(array('code'=>'100000','message'=>'签到成功'));
        }
    }

    //判断两天是否相连
    function isStreakDays($last_date,$this_date){
//        var_dump($last_date);die;
        if(($last_date['year']===$this_date['year'])&&($this_date['yday']-$last_date['yday']===1)){
            return true;
        }elseif(($this_date['year']-$last_date['year']===1)&&($last_date['mon']-$this_date['mon']=11)&&($last_date['mday']-$this_date['mday']===30)){
            return true;
        }else{
            return false;
        }
    }
//判断两天是否是同一天
    function isDiffDays($last_date,$this_date){

        if(($last_date['year']===$this_date['year'])&&($this_date['yday']===$last_date['yday'])){
            return false;
        }else{
            return true;
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
