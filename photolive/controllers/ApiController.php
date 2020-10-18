<?php

namespace photolive\controllers;

use photolive\models\Banner;
use photolive\models\Goods;
use photolive\models\News;
use photolive\models\PhotoList;
use photolive\models\PhotoType;
use photolive\models\PictureList;
use photolive\models\PyList;
use photolive\models\PyMessage;
use photolive\models\SignupForm;
use photolive\models\User;

class ApiController extends TokenController
{
    /**
     * 用户登录  \\ 前台与后台同步登录
     */
    public function actionLogin()
    {
        $params = \Yii::$app->request->post();
        $user = User::findOne(['phone'=>$params['phone']]);//通过用户输入的用户名重表中选出数据
        if($user){
            if(\Yii::$app->security->validatePassword($params['password'],$user->password)){
                //密码校验，第一个参数为用户输入的密码，第二个为通过用户名选出来用户原本的hash加密的密码
                $one = $user->attributes;
                $token = self::setTokenRadis($this->actionCreateToken($user->attributes['id']),$one);
                $oneModel = array('id'=>$one['id'],'username'=>$one['username'],'phone'=>$one['phone'],'token'=>$token);
                return $this->convertJson('100000', '登录成功', $oneModel);
            } else {
                if ($user->getFirstErrors()) {
                    foreach ($user->getFirstErrors() as $val) {
                        return $this->convertJson('100001', $val);
                    }
                }
            }
            return $this->convertJson('100001', '登录失败');
        }else{
            return $this->convertJson('100001', '此手机号码未注册');
        }

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
                $one = $user->attributes;
                $token = self::setTokenRadis($this->actionCreateToken($user->attributes['id']),$one);
                $oneModel = array('id'=>$one['id'],'username'=>$one['username'],'phone'=>$one['phone'],'token'=>$token);
                return $this->convertJson('100000', '注册成功', $oneModel);
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
     * 获取token过期时间
     */
    public function actionRedisTokenTime(){
        $headers = \Yii::$app->getRequest()->getHeaders();
        $token = $headers->get('token');
        return \Yii::$app->redis->TTL($token);
    }

    /**
     * 前后台同步退出 \\ 前台与后台同步退出
     */
    public function actionLogout()
    {
        $headers = \Yii::$app->getRequest()->getHeaders();
        $token = $headers->get('token');
        \Yii::$app->redis->del($token);
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

    /**************************************************  以上为个人中心部分 ******************************************************/


    /**************************************************  以下为网站信息部分 ******************************************************/

    /**
     * 首页数据
     */
    public function actionHome(){

        $data = [];
        $data['photoType'] = PhotoType::find()->asArray()->all();
        $data['banner']    = Banner::find()->asArray()->all();
        $data['case']      = PhotoList::find()->where(['status'=>1])->orderBy(['id'=>SORT_DESC])->limit(5)->asArray()->all();
        foreach ($data['case'] as $key=>$item){
            $data['case'][$key]['pass'] =  $data['case'][$key]['pass'] ? 1 : 0;
        }
        $data['news']      = News::find()->orderBy(['id'=>SORT_DESC])->limit(3)->asArray()->all();

        return $this->convertJson(100000,'查询成功',$data);
    }

    /**
     * 获取相册图片列表
     */
    public function actionCaseList()
    {
        $params = \Yii::$app->request->post();
        $query = PhotoList::find()->where(['status' => 1]);
        //按name查找
        if (isset($params['name']) && $params['name'] != '') {
            $query->andFilterWhere(['like', 'name', $params['name']]);
        }
        //按u_id查找
        if (isset($params['u_id'])) {
            $query->andFilterWhere(['u_id' => $params['u_id']]);
        }
        //按type查找
        if (isset($params['type']) && $params['type'] != '' && $params['type'] != 0) {
            $query->andFilterWhere(['type_id' => $params['type']]);
        }
        //按时间查找
        if (isset($params['starttime']) && isset($params['endtime'])) {
            $query->andFilterWhere(['and', ['>=', 'starttime', $params['starttime']], ['<=', 'endtime', $params['endtime']]]);
        }
        //按地点查找
        if (isset($params['province_id']) && isset($params['city_id']) && isset($params['area_id'])) {
            $query->andFilterWhere(['and', 'province_id=' . $params['province_id'], ['and', 'city_id=' . $params['city_id'], 'area_id=' . $params['area_id']]]);
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
        foreach ($list as $key=>$item) {
            $list[$key]['pass'] = $item['pass'] ? 1 : 0;
        }
        return self::convertJson(100000, '查询成功', $list, $count);
    }

    /**
     * 验证密码
     */
    public function actionRegPass(){
        $params = \Yii::$app->request->post();
        $passCount = \Yii::$app->redis->get('passCount');
        $passCount = $passCount ? $passCount : 0;
        if($passCount < 3){
            $model = PhotoList::findOne(['id'=>$params['project_id']]);
            if($model->pass == $params['pass']){
                return self::convertJson(100000, '验证通过');
            }else{
                \Yii::$app->redis->set('passCount',$passCount + 1);
                \Yii::$app->redis->expire('passCount', 60);
                return self::convertJson(100001, '密码错误');
            }
        }else{
            return self::convertJson(100001, '密码输入错误超过三次，请一分钟后重试');
        }
    }

    /**
     * 获取当前相册信息
     */
    public function actionPhotoOne()
    {
        $id = \Yii::$app->request->post('project_id');
        // 是否不获取其他关联项
        $no_other = \Yii::$app->request->post('no_other');
        if (!$id) {
            return self::convertJson('100001', '没有要查找的目标');
        }
        if (isset($no_other)) {
            $result = PhotoList::find()->where(['id' => $id])->asArray()->one();
        } else {
            $result = PhotoList::find()->joinWith(['photoCover', 'photoGroup', 'photoTopShare', 'photoWater', 'photoWxShare', 'photoType', 'pyInfo','photoSkin'])->where(['photo_list.id' => $id])->asArray()->one();
        }
        $result['pass'] = $result['pass'] ? 1 : 0;
        return self::convertJson('100000', '查询成功', $result);
    }

    /**
     * 相册添加修改
     */
    public function actionPhotoLook(){
        $id = \Yii::$app->request->post('id');
        if($id) {
            $model = PhotoList::findOne($id);
            $model->look = $model->look+1;
            if($model->save()){
                return true;
            }
        }
        return false;
    }

    /**
     * 获取相册图片详情
     */
    public function actionCaseDetail()
    {
        $params = \Yii::$app->request->post();
        $query = PictureList::find();
        if (!$params['project_id']) {
            return self::convertJson(100001, '项目不存在');
        }
        $query->where(['and',['project_id' => $params['project_id']],['status'=>1]]);
        if (isset($params) && $params['groupId'] != 0) {
            $query->andFilterWhere(['groupId' => $params['groupId']]);
        }
        if (isset($params) && $params['type'] !== '0') {
            $query->orderBy([$params['type'] => SORT_DESC]);
        } else {
            $query->orderBy(['id' => SORT_DESC]);
        }
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
    }

    /**
     * 获取热门十张照片并获取当前相册的总照片数
     */
    public function actionHotPicture(){
        $project_id = \Yii::$app->request->post('project_id');
        $query = PictureList::find()->where(['and',['project_id' => $project_id],['status'=>1]]);
        $count = $query->count();
        $data = $query->orderBy(['like' => SORT_DESC])->limit(10)->asArray()->all();
        return self::convertJson(100000, '查询成功', $data, $count);
    }

    /**
     * 图片点赞
     */
    public function actionPictureZan()
    {
        $params = \Yii::$app->request->post();
        $model = PictureList::findOne($params['id']);
        $model->like = $params['like'];
        if($model->save()){
            return self::convertJson('100000','点赞成功');
        };
        return self::convertJson('100001','点赞失败');
    }

    /**
     * 收藏功能
     */
    /*public function actionCollect(){
        $params = \Yii::$app->request->post();
        if(!$params['u_id']){

        }
    }*/


    /* 企业引流人选填写信息 */
    public function actionPyMessageInsertUpdate(){
        $params = \Yii::$app->request->post();
        if(!isset($params['id'])){
            $data = PyMessage::find()->where(['phone'=>$params['phone']])->one();
            if($data){
                return self::convertJson('100001','您已约拍成功，请勿重复约拍');
            }else{
                $model = new PyMessage();
                $message = '添加';
                $params['createtime'] = date('Y-m-d H:i:s',time());
            }
        }else{
            $message = "设置";
            $model = PyMessage::findOne($params['id']);
        }
        $model->setAttributes($params);
        if($model->save()){
            return self::convertJson('100000',$message.'成功');
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001',$message.'失败');
        }
    }

    /**
     * 新闻列表页
     */
    public function actionNewsList(){
        $params = \Yii::$app->request->post();
        $query = News::find();
        //按title查找
        if(isset($params['title'])){
            $query->andFilterWhere(['like','news.title',$params['title']]);
        }
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 50;
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->joinWith('newsType')->orderBy(['id' => SORT_DESC])->asArray()->all();
        return self::convertJson(100000, '查询成功', $list, $count);
    }
    /**
     * 新闻详情页
     */
    public function actionNewsDetails(){
        $news_id = \Yii::$app->request->post('id');
        $data = [];
        $data['list'] = News::find()->where(['and',['id'=>$news_id],['issue'=>2]])->one();
        if(!$data['list']){
            return self::convertJson('100001','新闻不存在');
        }
        // 添加观看量
        $data['list']->look = $data['list']->look + 1;
        $data['list']->save();
        $data['list'] = $data['list']->attributes;
        // 推荐新闻
        $data['recommend'] = News::find(['issue'=>2])->where(['recommend'=>1])->orderBy(['id'=>SORT_DESC])->limit(3)->asArray()->all();
        // 最新相册
        $data['phtoList'] = PhotoList::find(['status'=>1])->orderBy(['createtime'=>SORT_DESC])->limit(3)->asArray()->all();
        //查询上-篇文章
        $data['prev'] = News::find()->where(['and',['<', 'id', $news_id],['issue'=>2]])->limit(1)->asArray()->one();
        //查询下-篇文章
        $data['next'] = News::find()->where(['and',['>', 'id', $news_id],['issue'=>2]])->limit(1)->asArray()->one();

        return self::convertJson('100000','查询成功',$data);
    }

    /**
     * 品牌列表
     */
    public function actionPyList()
    {
        $params = \Yii::$app->request->post();
        $query = PyList::find();
        //按title查找
        if(isset($params['name'])){
            $query->andFilterWhere(['like','name',$params['name']]);
        }
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 50;
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->orderBy(['look' => SORT_DESC])->asArray()->all();
        return self::convertJson(100000, '查询成功', $list, $count);
    }

    /**
     * 品牌信息详情
     */
    public function actionPyOne()
    {
        $u_id = \Yii::$app->request->post('u_id');
        if ($u_id) {
            $pyOne = PyList::findOne(['u_id' => $u_id]);
            $pyOne->look = $pyOne->look + 1;
            $pyOne->save();
            $data = $pyOne->attributes;
            return self::convertJson('100000','查询成功',$data);
        } else {
            return self::convertJson(100001, '查询失败，用户不存在');
        }
    }

    /**
     * 商品列表
     */
    public function actionGoodsList(){
        $data = Goods::find()->where(['status'=>'1'])->asArray()->all();
        return self::convertJson(100000, '查询成功', $data);
    }

    // redis 测试
    public function actionRedis(){
        \Yii::$app->redis->set('test','111'); //设置redis缓存
        \Yii::$app->redis->expire('test',60); // 设置过期时间
    }

    public function actionGetRedis(){
        return \Yii::$app->redis->get('test'); //读取redis缓存
    }

}