<?php

namespace photolive\controllers;


use photolive\models\Goods;
use photolive\models\Order;
use photolive\models\PyMessage;
use yii\helpers\Json;
use yii\web\Controller;
use photolive\models\PhotoCoverSettings;
use photolive\models\PhotoGroupSettings;
use photolive\models\PhotoList;
use photolive\models\PhotoTopShareSettings;
use photolive\models\PhotoWaterArray;
use photolive\models\PhotoWaterSettings;
use photolive\models\PhotoWxShareSettings;
use photolive\models\PictureList;
use photolive\models\PyList;

class UserController extends TokenController
{
    public $uid = 0;
    public function beforeAction($action)
    {
        /* 验证是否为登录状态 */
        $headers = \Yii::$app->getRequest()->getHeaders();
        $token = $headers->get('token');
        $this->uid = Json::decode(\Yii::$app->redis->get($token))['id'];
        //安全认证(检测Token)
        $checkRes = $this->checkToken($this->uid,$token);
        if ($checkRes['code'] != 200) {
            echo Json::encode($checkRes);
            return false;
        }
        $project_id = \Yii::$app->request->post('project_id');
        if($project_id){
            $count = PhotoList::find()->where(['and',['id'=>$project_id],['u_id'=>$this->uid]])->count();
            if(!$count){
                echo self::convertJson(402, '无权限');
                return false;
            }
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * 删除oss上某个目录以及以下所有文件
     * 传入文件路径
     */
    public function actionDelDir($dir = '')
    {
        $dir = $dir ? $dir : \Yii::$app->request->post('dir');
        if ($dir) {
            if (Yii::$app->Aliyunoss->deleteDir($dir)) {
                return $this->convertJson('100000', '删除成功');
            };
            return $this->convertJson('100000', '删除失败');
        } else {
            return $this->convertJson('100000', '您要删除的文件已不存在');
        }
    }

    /**
     * @return 本地删除文件
     */
    public function deleteFile($file)
    {
        $file = $file ? $file : \Yii::$app->request->post('fileSrc');
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

    /**
     * 获取相册列表
     */
    public function actionPhotoList()
    {
        $params = \Yii::$app->request->post();
        $query = PhotoList::find()->where(['u_id' => $this->uid]);
        //按name查找
        if (isset($params['name'])) {
            $query->andFilterWhere(['like', 'name', $params['name']]);
        }
        //status查询
        if(isset($params['status'])){
            $query->andFilterWhere(['status'=>$params['status']]);
        }
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 50;
        $count = 0;
        if ($page && $limit) {
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->orderBy(['id' => SORT_DESC])->asArray()->all();
        for ($i = 0; $i < count($list); $i++) {
            $countNumber = PictureList::find()->where(['project_id' => $list[$i]['id']])->count();
            $list[$i]['photo_number'] = $countNumber;
        }
        return self::convertJson(100000, '查询成功', $list, $count);
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
        if ($params['id']) {
            $model = PhotoGroupSettings::findOne($params['id']);
        } else {
            $params['createtime'] = date('Y-m-d H:i:s', time());
        }
        $model->setAttributes($params);
        if ($model->save()) {
            if (!isset($model->attributes['sort'])) {
                $model->updateAll(['sort' => $model->attributes['id']], ['id' => $model->attributes['id']]);
            }
            return self::convertJson('100000', '操作成功');
        } else {
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001', '操作失败');
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
        foreach ($params['style'] as $key => $item) {
            $model = PhotoWaterSettings::findOne([['id' => $item['id']], ['position' => $item['position']]]);
            if (!$model) {
                // 新增方法
                $model = new PhotoWaterSettings();
                $item['position'] = $key;
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
        $water_image = PhotoWaterArray::find()->where(['project_id' => $project_id])->asArray()->all();
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
        } else {
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
        if ($params['id']) {
            $model = PhotoWaterArray::findOne($params['id']);
        } else {
            $params['createtime'] = date('Y-m-d H:i:s', time());
        }
        $model->setAttributes($params);
        if ($model->save()) {
            return self::convertJson('100000', '操作成功', $model->attributes);
        } else {
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001', '操作失败');
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
    public function actionPictureList()
    {
        $id = \Yii::$app->request->post('project_id');
        return PictureList::getPictureList(['project_id' => $id]);
    }

    /**
     * 获取相册是否存在图片
     */
    public function actionPictureOne(){
        $id = \Yii::$app->request->post('project_id');
        return PictureList::getOne(['project_id' => $id]);
    }

    /**
     * 添加修改相册图片
     */
    public function actionPictureInsertUpdate()
    {
        $params = \Yii::$app->request->post();
        return PictureList::pictureInsertUpdate($params);
    }

    /**
     * 批量更新相册图片
     */
    public function actionPictureArrUpdate()
    {
        $params = \Yii::$app->request->post();
        $ids = $params['picture_list'];
        $result = PictureList::updateAll(['groupId' => $params['groupId']], ['id' => $ids]);
        if ($result) {
            return self::convertJson('100000', '更新成功');
        } else {
            return self::convertJson('100001', '更新失败');
        }
    }

    /**
     * 批量删除相册图片
     */
    public function actionPictureArrRemove()
    {
        $ids = \Yii::$app->request->post('ids');
        $removeImgArr = \Yii::$app->request->post('removeImgArr');
        $result = PictureList::deleteAll(['id' => $ids]);
        if ($result) {
            $this->actionDelFile($removeImgArr);
            return self::convertJson('100000', '删除成功');
        } else {
            return self::convertJson('100001', '删除失败');
        }
    }

    /**
     * 品牌信息
     */
    public function actionPyOne()
    {
        if ($this->uid != 0) {
            return PyList::getOne(['u_id' => $this->uid]);
        } else {
            return self::convertJson(100001, '查询失败，用户不存在');
        }
    }

    /**
     * 品牌更新与修改
     */
    public function actionPyInsertUpdate()
    {
        $params = \Yii::$app->request->post();
        return PyList::insertUpdate($params);
    }

    /**
     * 品牌删除
     */
    public function actionPyDelete()
    {
        $id = \Yii::$app->request->post('id');
        return PyList::deleteOne($id);
    }

    /**
     * 企业引流人员列表
     */
    public function actionPyMessageList()
    {
        $params = \Yii::$app->request->post();
        if ($this->uid) {
            $query = PyMessage::find()->where(['u_id'=>$this->uid])->orderBy(['createtime'=>SORT_DESC]);
            $page = isset($params['page']) ? $params['page'] : 1;
            $limit = isset($params['limit']) ? $params['limit'] : 50;

            $count = 0;
            if ($page && $limit) {
                $offset = ($page - 1) * $limit;
                $count = $query->count();
                $query->offset($offset)->limit($limit);
            }
            $list = $query->asArray()->all();
            return self::convertJson(100000, '查询成功', $list, $count);
        } else {
            return self::convertJson(100001, '查询失败，用户不存在');
        }
    }

    /**
     * 企业引流人员单个删除
     */
    public function actionPyMessageRemove()
    {
        return PyMessage::deleteOne($this->uid);
    }


    /**
     * 查询用户订单信息
     */
    public function actionOrderList(){
        $params = \Yii::$app->request->post();
        if($this->uid != 0){
            $order = Order::find();
            if(isset($params['status'])){
                $order->andFilterWhere(['status'=>$params['status']]);
            }
            $list = $order->asArray()->all();
            return self::convertJson(100000, '查询成功', $list);
        }else{
            return self::convertJson(100001, '查询失败');
        }
    }

    /**
     * 新增订单
     */
    public function actionInsertUpdateOrder(){
        $params = \Yii::$app->request->post();
        $model = new Order();
        if(Order::findOne($params['good_id'])){
            return self::convertJson('100001','已加入购物车');
        }
        $params['createtime'] = date('Y-m-d H:i:s',time());
        $model->setAttributes($params);
        if($model->save()){
            return self::convertJson('100000','插入成功');
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001','插入失败');
        }
    }
}