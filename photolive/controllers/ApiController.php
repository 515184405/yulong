<?php

namespace photolive\controllers;


use common\models\UploadForm;
use photolive\models\LoginForm;
use photolive\models\PhotoCoverSettings;
use photolive\models\PhotoGroupSettings;
use photolive\models\PhotoList;
use photolive\models\PhotoTopShareSettings;
use photolive\models\PhotoType;
use photolive\models\PhotoWaterArray;
use photolive\models\PhotoWaterSettings;
use photolive\models\PhotoWxShareSettings;
use photolive\models\PictureList;
use photolive\models\SignupForm;
use photolive\models\User;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ApiController extends Controller
{

    /**转Json格式
     * @param $code
     * @param $message
     * @param $data
     * @param $count
     * @return string
     */
    public function convertJson($code, $message, $data = '', $count = null)
    {

        $Json['code'] = $code;
        $Json['message'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);
    }

    //删除文件  $path为绝对路径
    public function actionDelFile()
    {
        $file = \Yii::$app->request->post('fileSrc');
        if (file_exists($file)) {
            $url = iconv('utf-8', 'gbk', $file);
            if (PATH_SEPARATOR == ':') { //linux
                if (unlink($file)) {
                    return $this->convertJson('100000', '删除成功');
                }
            } else {  //Windows
                if (unlink($url)) {
                    return $this->convertJson('100000', '删除成功');
                };
            }
            return $this->convertJson('100000', '删除失败');
        } else {
            return $this->convertJson('100000', '您要删除的文件已不存在');
        }
    }

    /* 删除文件夹以及文件夹下所有文件 */
    public function actionDelDir() {
        $dir = \Yii::$app->request->post('dir');
        if($this->delDir($dir)){
            return $this->convertJson('100000', '数据清理完成');
        };
        return $this->convertJson('100000', '数据清理完成');
    }
    /* 删除目录 */
    public function delDir($dir){
        //先删除目录下的文件：
        if(!is_dir($dir)) return false;
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->delDir($fullpath);
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


    /**
     * @return array
     * 图片上传
     */
    public function actionUploadImage()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $params = \Yii::$app->request->post();
            $dress = isset($params['dir']) ? $params['dir'] . '/' : 'common/';
            $rootDir = 'uploads/' . $dress;

            $model->file = UploadedFile::getInstanceByName('file');  //这个方式是js提交
            $image_name = $model->file->name;
            $image_size = $model->file->size;
            if ($model->file && $model->validate()) {
                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                $date = date('Ymd') . '_';
                $fileSrc = $rootDir . $date . rand(10000, 99999) . time() . '.' . $model->file->extension;
                $model->file->saveAs($fileSrc);
                $photoInfo = getimagesize($fileSrc);

                //压缩图片
                /* if($iscompress){
                     $source = $fileSrc;
                     $dst_img = $fileSrc; //可加存放路径
                     $percent = 1;  #原图压缩，不缩放
                     (new Imgcompress($source,$percent))->compressImg($dst_img);
                 }*/
                return $this->convertJson('100000', '上传成功', array('fileSrc' => $fileSrc,'filesize'=>$image_size,'name'=>$image_name,'width'=>$photoInfo[0],'height'=>$photoInfo[1]));
            }
            return $this->convertJson('100001', '上传失败');
        }
    }

    /**
     * 用户登录  \\ 前台与后台同步登录
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post(), '')) { //载入post所获取的数据
            if ($user = $model->loginup()) {
                $one = array(
                    'id'=>$user->attributes['id'],
                    'username'=>$user->attributes['username'],
                    'sex'=>$user->attributes['sex'],
                    'province_id'=>$user->attributes['province_id'],
                    'city_id'=>$user->attributes['city_id'],
                    'area_id'=>$user->attributes['area_id'],
                    'phone'=>$user->attributes['phone'],
                );
                return $this->convertJson('100000', '登录成功',$one);
            } else {
                if ($model->getFirstErrors()) {
                    foreach ($model->getFirstErrors() as $val) {
                        return $this->convertJson('100001', $val);
                    }
                }
            }
        }
        return $this->convertJson('100001', '登录失败');
    }

    /**
     * 用户注册 \\ 前台与后台同步登录
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post(), '')) { //载入post所获取的数据
            $user = $model->signup();
            if ($user) {
                if (\Yii::$app->getUser()->login($user, 3600 * 24 * 7)) {
                    //return $this->goHome();
                    $id = $user->id;
                    $one = User::find()->where(['id' => $id])->select(['id', 'username', 'sex', 'province_id', 'city_id', 'area_id', 'phone'])->asArray()->one();
                    return $this->convertJson('100000', '注册成功', $one);
                }
            } else {
                if ($model->getFirstErrors()) {
                    foreach ($model->getFirstErrors() as $val) {
                        return $this->convertJson('100001', $val);
                    }
                }
            }
            return $this->convertJson('100001', '注册失败');
        }
    }

    /**
     * 前后台同步退出 \\ 前台与后台同步退出
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->convertJson('100000', '成功退出');

    }

    /**
     * 获取省市区
     */
    public function actionGetCitys()
    {
        $json_string = file_get_contents('../web/json/china.json');

        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);

        return $this->convertJson('100000', '获取成功', $data);

    }

    /**
     * 获取相册类型
     */
    public function actionPhotoType()
    {
        return PhotoType::getList();
    }

    /**
     * 获取相册列表
     */
    public function actionPhotoList()
    {
        $params = \Yii::$app->request->post();
        $result = PhotoList::find()->where(['u_id' => $params['u_id']])->asArray()->all();
        for($i = 0;$i < count($result);$i++){
            $count = PictureList::find([['u_id' => $params['u_id']],['project_id'=>$result[$i]['id']]])->asArray()->count();
            $result[$i]['photo_number'] = $count;
        }
        return self::convertJson('100000','查询成功',$result);
    }

    /**
     * 获取当前相册信息
     */
    public function actionPhotoOne()
    {
        $id = \Yii::$app->request->post('project_id');
        if(!$id){
            return self::convertJson('100001','没有要查找的目标');
        }
        $result = PhotoList::find()->joinWith(['photoCover','photoGroup','photoTopShare','photoWater','photoWxShare'])->where(['photo_list.id'=>$id])->asArray()->one();
        return self::convertJson('100000','查询成功',$result);
    }

    /**
     * 创建与更新相册
     */
    public function actionCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        return PhotoList::insertUpdate($params);
    }

    /**
     * 删除相册
     */
    public function actionPhotoRemove()
    {
        $id = \Yii::$app->request->post('id');
        if ($id) {
            $model = new PhotoList();
            $model->deleteAll(['id' => $id]);
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            /* 相册封面删除 */
            $model2 = new PhotoCoverSettings();
            $model2->deleteAll(['project_id' => $id]);

            /* 相册顶图删除 */
            $model3 = new PhotoTopShareSettings();
            $model3->deleteAll(['project_id' => $id]);

            /* 相册分组删除 */
            $model4 = new PhotoGroupSettings();
            $model4->deleteAll(['project_id' => $id]);

            /* 相册水印删除 */
            $model5 = new PhotoWaterSettings();
            $model5->deleteAll(['project_id' => $id]);

            /* 相册水印图片删除 */
            $model6 = new PhotoWaterArray();
            $model6->deleteAll(['project_id' => $id]);

            /* 相册微信分享删除 */
            $model7 = new PhotoWxShareSettings();
            $model7->deleteAll(['project_id' => $id]);

            return self::convertJson('100000', '删除成功');
        } else {
            return self::convertJson('100001', '没有找到要删除的目标');
        }
        return PhotoList::deleteOne($id);
    }

    /**
     * 创建与更新相册分组
     */
    public function actionPhotoGroupCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        $model = new PhotoGroupSettings();
        if($params['id']) {
            $model = PhotoGroupSettings::findOne($params['id']);
        }else{
            $params['createtime'] = date('Y-m-d H:i:s',time());
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!isset($model->attributes['sort'])){
                $model->updateAll(['sort'=>$model->attributes['id']],['id'=>$model->attributes['id']]);
            }
            return self::convertJson('100000','操作成功');
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001','操作失败');
        }
    }

    /**
     * 删除相册分组
     */
    public function actionPhotoGroupRemove()
    {
        $id = \Yii::$app->request->post('id');
        return PhotoGroupSettings::deleteOne($id);
    }

    /**
     * 获取分组列表
     */
    public function actionPhotoGroupList()
    {
        $params = \Yii::$app->request->post();
        $result = PhotoGroupSettings::find()->where(['project_id' => $params['project_id']])->orderBy(['sort' => SORT_ACE])->asArray()->all();
        return self::convertJson('100000', '查询成功', $result);
    }

    /**
     * 分组排序
     */
    public function actionPhotoGroupSort()
    {
        $params = \Yii::$app->request->post();
        foreach ($params as $key => $val) {
            $model = new PhotoGroupSettings();
            $model->updateAll(['sort' => $val['sort']], ['id' => $val['id']]);
        }
        if ($model->getFirstErrors()) {
            foreach ($model->getFirstErrors() as $val) {
                return self::convertJson('100001', $val);
            }
        }
        return self::convertJson('100000', '修改成功');
    }

    /**
     * 创建与更新相册封面配置
     */
    public function actionPhotoCoverCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        return PhotoCoverSettings::insertUpdate($params);
    }

    /**
     * 获取相册封面配置
     */
    public function actionPhotoCoverOne()
    {
        $project_id = \Yii::$app->request->post('project_id');
        return PhotoCoverSettings::getOne(['project_id' => $project_id]);
    }

    /**
     * 创建与更新相册顶部宣传图配置
     */
    public function actionPhotoTopShareCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        return PhotoTopShareSettings::insertUpdate($params);
    }

    /**
     * 获取相册宣传图配置
     */
    public function actionPhotoTopShareOne()
    {
        $project_id = \Yii::$app->request->post('project_id');
        return PhotoTopShareSettings::getOne(['project_id' => $project_id]);
    }

    /**
     * 创建与更新相册微信分享配置
     */
    public function actionPhotoWxShareCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        return PhotoWxShareSettings::insertUpdate($params);
    }

    /**
     * 获取相册微信分享配置
     */
    public function actionPhotoWxShareOne()
    {
        $project_id = \Yii::$app->request->post('project_id');
        return PhotoWxShareSettings::getOne(['project_id' => $project_id]);
    }

    /**
     * 创建与更新相册水印配置
     */
    public function actionPhotoWaterCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        foreach ($params['style'] as $key=>$item) {
            $model = PhotoWaterSettings::findOne([['id' => $item['id']], ['position' => $item['position']]]);
            if (!$model) {
                // 新增方法
                $model = new PhotoWaterSettings();
                $item['position']  = $key;
                $item['createtime'] = date('Y-m-d H:i:s', time());
            }
            $model->setAttributes($item);
            if (!$model->save()) {
                if ($model->getFirstErrors()) {
                    foreach ($model->getFirstErrors() as $val) {
                        return self::convertJson('100001', $val);
                    }
                }
                return self::convertJson('100001', '水印失败');
            }
        }
        return self::convertJson('100000', '水印成功');
    }

    /**
     * 获取相册水印配置
     */
    public function actionPhotoWaterOne()
    {
        $project_id = \Yii::$app->request->post('project_id');
        $result = PhotoWaterSettings::find()->where(['Photo_water_settings.project_id' => $project_id])->joinWith(['water_arr'])->asArray()->all();
        $water_image = PhotoWaterArray::find()->where(['project_id'=>$project_id])->asArray()->all();
        if (!$result) {
            $result = array(
                'type' => 1,
                'water_image' => $water_image,
                'style' => array(
                    '1' => array(
                        'width' => 20,
                        'padding' => 10,
                        'opacity' => 100,
                        'imgsrc' => ''
                    ),
                    '2' => array(
                        'width' => 20,
                        'padding' => 10,
                        'opacity' => 100,
                        'imgsrc' => ''
                    ),
                    '3' => array(
                        'width' => 20,
                        'padding' => 10,
                        'opacity' => 100,
                        'imgsrc' => ''
                    ),
                    '4' => array(
                        'width' => 20,
                        'padding' => 10,
                        'opacity' => 100,
                        'imgsrc' => ''
                    )
                )
            );
        }else{
            $resultTmp = array();
            $resultTmp['water_image'] = $water_image;
            foreach ($result as $index => $item) {
                $resultTmp['style'][$item['position']] = $item;
                $resultTmp['style'][$item['position']]['imgsrc'] = $item['water_arr']['imgsrc'];
            }
            $resultTmp['type'] = $result[0]['type'];
            $result = $resultTmp;
        }
        return self::convertJson('100000', '查询成功', $result);
    }

    /**
     * 更新水印数据
     */
    public function actionPhotoWaterArrCreateUpdate()
    {
        $params = \Yii::$app->request->post();
        $model = new PhotoWaterArray();
        if($params['id']) {
            $model = PhotoWaterArray::findOne($params['id']);
        }else{
            $params['createtime'] = date('Y-m-d H:i:s',time());
        }
        $model->setAttributes($params);
        if($model->save()){
            return self::convertJson('100000','操作成功',$model->attributes);
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001','操作失败');
        }
    }

    /**
    * 删除水印数据
    */
    public function actionWaterArrRemove()
    {
        $id = \Yii::$app->request->post('id');
        return PhotoWaterArray::deleteOne($id);
    }

    /**
     * 获取相册图片列表
     */
    public function actionPictureList(){
        $id = \Yii::$app->request->post('project_id');
        return PictureList::getPictureList(['project_id'=>$id]);
    }

    /**
     * 添加修改相册图片
     */
    public function actionPictureInsertUpdate(){
        $params = \Yii::$app->request->post();
        return PictureList::pictureInsertUpdate($params);
    }

    /**
     * 批量更新相册图片
     */
    public function actionPictureArrUpdate(){
        $params = \Yii::$app->request->post();
        $ids = $params['picture_list'];
        $result = PictureList::updateAll(['groupId'=>$params['groupId']],['id'=>$ids]);
        if($result){
            return self::convertJson('100000','更新成功');
        }else{
            return self::convertJson('100001','更新失败');
        }
    }

    /**
     * 批量删除相册图片
     */
    public function actionPictureArrRemove(){
        $ids = \Yii::$app->request->post('ids');
        $result = PictureList::deleteAll(['id'=>$ids]);
        if($result){
            return self::convertJson('100000','删除成功');
        }else{
            return self::convertJson('100001','删除失败');
        }
    }



    /**************************************************  以上为个人中心部分 ******************************************************/



    /**************************************************  以下为网站信息部分 ******************************************************/

    /**
     * 获取相册列表
     */
    public function actionCaseList(){
            $params = \Yii::$app->request->post();
            $query = PhotoList::find();
            //按name查找
            if(isset($params['name'])){
                $query->andFilterWhere(['like','name',$params['name']]);
            }
            //按type查找
            if(isset($params['type'])){
                $query->andFilterWhere(['type_id'=>$params['type']]);
            }
            //按时间查找
            if(isset($params['starttime']) && isset($params['endtime'])){
                $query->andFilterWhere(['and',['>=','starttime',$params['starttime']],['<=','endtime',$params['endtime']]]);
            }
            //按地点查找
            if(isset($params['province_id']) && isset($params['city_id']) && isset($params['area_id'])){
                $query->andFilterWhere(['and', 'province_id='.$params['province_id'], ['and', 'city_id='.$params['city_id'], 'area_id='.$params['area_id']]]);
            }
            $page = isset($params['page']) ? $params['page'] : 1;
            $limit = isset($params['limit']) ? $params['limit'] : 50;
            $count = 0;
            if($page && $limit){
                $offset = ($page - 1) * $limit;
                $count = $query->count();
                $query->offset($offset)->limit($limit);
            }
            //$list = $query->joinWith('caseType')->orderBy(['id' => SORT_DESC])->asArray()->all();
            $list = $query->orderBy(['id' => SORT_DESC])->asArray()->all();
            return self::convertJson(100000,'查询成功',$list,$count);
    }

}