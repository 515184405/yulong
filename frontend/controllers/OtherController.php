<?php
namespace frontend\controllers;


use common\models\MadeToOrder;
use common\models\UserCollect;
use common\models\UserDownRecord;
use common\models\UserGuanzhu;
use common\models\UserInfo;
use common\models\UserScope;
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
class OtherController extends CommonController
{

    public function beforeAction($action)
    {
        //如果未登录，则直接返回
        if(Yii::$app->user->isGuest){
            return $this->redirect('/site/login');
        }

        $userInfo = Yii::$app->view->params['userInfo'];
        if($userInfo['status'] === 1){
            return $this->redirect('/site/status');
        }

        return true;

    }


    public function actionIndex()
    {
        $uid = Yii::$app->user->id;
        $other = isset($_GET['u_id']) ? $_GET['u_id'] : 0;
        $type = isset($_GET['type']) ? $_GET['type'] : 1;
        if($type>2){
            return $this->redirect('/site/404');
        }
        $guanzhu = UserGuanzhu::find()->joinWith('member')->where(['u_id'=>$uid,'other_id'=>$other])->one();
        if(!$guanzhu){
            return '没有关注人的信息';
        }
        if($type == 1){
            $widget = Widget::find()->select(['id','title','desc','banner_url','look','fail_msg','collect','down_count','status','upload_download'])->where(['status'=>1,'u_id'=>$other])->orderBy(['id'=>SORT_DESC]);
        }else{
            $widget = UserCollect::find()->where(['user_collect.u_id'=>$other])->joinWith('collect_widget');
        }

        $params = Yii::$app->request->get();
        $limit =20; //每页显示20条
        $page = isset($params['page']) ? $params['page'] : 1;

        $pagination = new Pagination(['totalCount' => count($widget),'pageSize' => $limit]);
        $widget = $widget->offset(($page-1)*$limit)->limit($limit)->asArray()->all();

        //个人中心访问量，粉丝量等等
        $personalInfo = UserInfo::find()->where(['uid'=>$other])->asArray()->one();
        //积分总量
        $scope = UserScope::find()->where(['uid'=>$other])->asArray()->one();
        $data = [
            'widget'=>$widget,
            'pagination' => $pagination,
            'personalInfo' => $personalInfo,
            'guanzhu' => $guanzhu['member'],
            'scope' => $scope,
        ];
        return $this->render('index',compact('data'));
    }

    //按分类取组件
    public function limitPage($params,$condition){
        /*按分类取组件*/
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
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
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
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
        $uid = Yii::$app->user->id ? Yii::$app->user->id : 0;
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
            $params['u_id'] = Yii::$app->user->id;
            //存widgetModel数据
            $widget_id2 = Widget::insertUpdate($params,$widget_id);
            if($widget_id2){
                if($widget_id){
                    Yii::$app->session['widget_create_id'] = $widget_id;
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！','id'=>$widget_id));
                }
                //生成静态文件地址
                $rootDir2 = '../../frontend/web/widget_file/'.$widget_id2;
                is_dir($rootDir2) OR mkdir($rootDir2, 0777, true);
                Yii::$app->session['widget_create_id'] = $widget_id2;
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','id'=>$widget_id2));
            };
        }

        //查询组件数据
        if($widget_id){
            $data['widget'] = widget::find()->where(['id'=>$widget_id,'u_id'=>Yii::$app->user->id])->asArray()->one();
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
        $uid =  Yii::$app->user->id ? Yii::$app->user->id : 0;
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
        $uid =  Yii::$app->user->id ? Yii::$app->user->id : 0;
        $guanZhu = UserGuanzhu::find()->joinWith('member')->where(['u_id'=>$uid])->asArray()->all();
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
            $widget = Widget::findOne($id);
            if(!$id){
                return Json::encode(array('code'=>'100001','message'=>'上传失败！'));
            }
            $time = time();
            if($widget->status == 1){
                $rootDir = '../../frontend/web/upload_file/'.$id.'/';
            }else{
                $rootDir = '../../frontend/web/widget_file/'.$id.'/';
            }
            is_dir($rootDir) OR mkdir($rootDir, 0777, true);
            //删除原有文件
            is_dir($rootDir) AND $this->deldir($rootDir);
            $model->file = UploadedFile::getInstanceByName('file');  //这个方式是js提交
            if ($model->file && $model->validate()) {
                $name = explode('.',$model->file->name);
                $zip = array_pop($name);
                //join('.',$name);

                //判断文件名中是否有中文
                if (preg_match("/[\x7f-\xff]/", $model->file->name)) {
                    $name = $time.$id.'.'.$zip;
                }else{
                    //$name = $model->file->name;
                    $name = $name[0].$time.'.'.$zip;
                }

                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                $fileSrc=$rootDir . $name;
                if($model->file->saveAs($fileSrc)){
                    //解压缩
                    if($zip == 'zip'){
                        $this->unZip($fileSrc,$rootDir);
                    }else{
                        $this->unRar($fileSrc,$rootDir);
                    }
                    //删除压缩包
                    //unlink($fileSrc);
                    $viewDir = '../../frontend/views/widget-file/'.$id.'/';
                    $enter_file = $this->getDir($rootDir,$viewDir,$rootDir);
                    if($widget->status == 1){
                        $download = '/upload_file/' . $id . '/' . $name;
                        $widget->upload_download = $download;
                        $widget->upload_enter_file = $enter_file;
                    }else{
                        $download = '/widget_file/' . $id . '/' . $name;
                        $widget->download = $download;
                        $widget->enter_file = $enter_file;
                    }

                    if($widget->save()){
                        return Json::encode(array('code'=>'100000','message'=>'上传成功！','data'=>array(
                            'name' => $name,
                            'download' => $download,
                        )));
                    }else{
                        return Json::encode(array('code'=>'100000','message'=>'图片上传成功，但并未保存到库中！','data'=>array(
                            'name' => $name,
                            'download' => $download,
                        )));
                    }

                }
                return Json::encode(array('code'=>'100001','message'=>'上传失败！'));

            }
            return Json::encode(array('code'=>'100001','message'=>'上传失败！'));
        }
    }

    public function unZip($filepath,$extractTo){

        $zip = new \ZipArchive();
        $res = $zip->open($filepath);
        if ($res === TRUE) {
            //解压缩到$extractTo指定的文件夹
            $zip->extractTo($extractTo);
            $zip->close();
        } else {
            echo 'failed, code:' . $res;
        }
    }

    public function unRar($filepath,$extractTo){

        $fileName = iconv('utf-8','gb2312',$filepath);
//        echo $fileName . '</br>';

        $rar_file = rar_open($fileName) or die('could not open rar');
        $list = rar_list($rar_file) or die('could not get list');
//        print_r($list);

        foreach($list as $file) {
            $pattern = '/\".*\"/';
            preg_match($pattern, $file, $matches, PREG_OFFSET_CAPTURE);
            $pathStr=$matches[0][0];
            $pathStr=str_replace("\"",'',$pathStr);
//            print_r($pathStr);
            $entry = rar_entry_get($rar_file, $pathStr) or die('</br>entry not found');
            $entry->extract($extractTo); // extract to the current dir
        }
        rar_close($rar_file);
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

    //复制.html文件
    /*
     * @path 当前上传文件地址
     * @extractTo 文件输出地址
     * @rootDir 文件上传后存放地址
     * */
    public $fileNameDir = '';
    public function getDir($path,$extractTo,$rootDir){
        if(is_dir($path)){

            $dir =  scandir($path);
            foreach ($dir as $value){
                if(substr($path,-1) === '/'){
                    $sub_path = $path.$value;
                }else{
                    $sub_path =$path .'/'.$value;
                }

                if($value == '.' || $value == '..'){
                    continue;
                }else if(is_dir($sub_path)){
                    $this->getDir($sub_path,$extractTo,$rootDir);
                }else{
                    $fileNameArr = explode('.',$value);
                    if(end($fileNameArr) === 'html'){
                        if($fileNameArr[0] == 'index'){
                            $this->fileNameDir = str_replace($rootDir,'',$path) . '/index.html';
                        }else{
                            if(!$this->fileNameDir){
                                $this->fileNameDir = str_replace($rootDir,'',$path) . '/'.$fileNameArr[0].'.html';
                            }
                        }
                        //rename($path. '/'.$value,$extractTo.$resetName.$value);
                    };
                }
            }
        }
        return $this->fileNameDir;
    }
}
