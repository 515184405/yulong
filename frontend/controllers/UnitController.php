<?php
namespace frontend\controllers;

use common\models\Cases;
use common\models\MadeToOrder;
use common\models\Member;
use common\models\News;
use common\models\Pinglun;
use common\models\UserCollect;
use common\models\UserDownRecord;
use common\models\UserGuanzhu;
use common\models\UserInfo;
use common\models\UserScope;
use common\models\UserScopeRecord;
use common\models\Widget;
use common\models\WidgetType;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;

class UnitController extends CommonController {

    public function actionIndex(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $unitData = Widget::find()->where(['status'=>1])->orderBy(['id'=>SORT_DESC])->andFilterWhere(['or',['like','title',$search],['like','desc',$search]])->asArray()->all();
        $limit = 23; //每页显示20条
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $unit = [];
        $is_true = false; //判断当前类型是否存在项目
        foreach ($unitData as $item) {
            $typeTitle = [];
            $is_true = false;
            foreach (explode(',',$item['type']) as $type) {
                $typeModel = WidgetType::findOne($type);
                if($typeModel){
                    array_push($typeTitle,$typeModel->title);
                    if($type == $id && $is_true !== true){
                        $is_true = true; //当前类型中存在项目
                    }
                }
            }
            if($id) {
                if ($is_true) {
                    $item['type_tag'] = $typeTitle;
                    array_push($unit, $item);
                }
            }else{
                $item['type_tag'] = $typeTitle;
                array_push($unit, $item);
            }
        }
        $pagination = new Pagination(['totalCount' => count($unit),'pageSize' => $limit]);
        $unit = array_slice($unit,$limit*($page-1),$limit);

        $type = WidgetType::find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'unit',
            'unit' => $unit,
            'pagination' => $pagination
        );
        return $this->renderPartial('index',compact('data'));
    }

    public function actionItem(){
        $params =\Yii::$app->request->get();
        //管理员可看
        $auth = isset($params['auth']) ? $params['auth'] : "";
        $unit_id = isset($params['widget_id']) ? $params['widget_id'] : "";
        if($auth == '0777'){
            //管理员可看
            $widget_item = Widget::find()->joinWith('userInfo')->where(['widget.id'=>$unit_id])->asArray()->one();
        }else{
            //所有可见
            $widget_item = Widget::find()->joinWith('userInfo')->where(['and',['widget.id'=>$unit_id],['widget.status'=>'1']])->asArray()->one();
        }
        //点击率加1
        $widget_item_look = Widget::findOne($unit_id);

        if(!$widget_item){
            return '项目不存在';
        }
        $widget_item_look->look = intval($widget_item_look->look) + 1;
        $widget_item_look->save();

        //查询上-篇文章
        $prev_article = Widget::find()->andFilterWhere(['and',['<', 'id', $unit_id],['status'=>1]])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        //查询下-篇文章
        $next_article = Widget::find()->andFilterWhere(['and',['>', 'id', $unit_id],['status'=>1]])->orderBy(['id' => SORT_ASC])->limit(1)->one();

        $user_id = $widget_item['u_id'];
        $collect = UserCollect::find();
        $guanzhu = UserGuanzhu::find();
        $collectCount = $collect->where(['widget_id'=>$unit_id])->count();
        $guanzhuCount = $guanzhu->where(['other_id'=>$widget_item['u_id']])->count();
        if($user_id || $user_id == 0){
            $collect = $collect->where(['u_id'=>$user_id,'widget_id'=>$unit_id])->asArray()->one();
            $guanzhu = $guanzhu->where(['u_id'=>\Yii::$app->user->id,'other_id'=>$user_id])->asArray()->one();
            $widget_item['user'] = [
                'collect' => $collect,
                'guanzhu' => $guanzhu,
            ];
        };
        $widget_item['user']['collectCount'] = $collectCount;
        $widget_item['user']['guanzhuCount'] = $guanzhuCount;

        //评论数据
        $pinglun = Pinglun::find()->where(['widget_id'=>$unit_id])->asArray()->all();
        $pinglunCount = count($pinglun);
        for($i = 0; $i < count($pinglun);$i++){
            for($j = 0; $j < count($pinglun);$j++){
                if($pinglun[$i]['id'] == $pinglun[$j]['parent_id']){
                    if(!isset($pinglun[$i]['child'])){
                        $pinglun[$i]['child'] = [];
                    }
                    $pinglun[$i]['child'][] = $pinglun[$j];
                    array_splice($pinglun,$j,1);
                    $j--;
                }
            }
       }

       //当前用户剩余积分
        $uid = \Yii::$app->user->id;
        $scope = UserScope::find()->where(['uid'=>$uid])->asArray()->one();

        $data = array(
            'link' => 'unit',
            'prev' => $prev_article,
            'next' => $next_article,
            'data' => $widget_item,
            'pinglun' => $pinglun,
            'pinglunCount' => $pinglunCount,
            'scope' => $scope['scope']
        );
        return $this->renderPartial('item',compact('data','unit_id'));
    }

    //收集下载量
    public function actionDownCount(){

        if(isset($_COOKIE['DownCount'])){
            setcookie("DownCount", 1, time()+1,'/');
            return Json::encode(['code'=>'100002','message'=>'请不要频繁操作，1s后再试']);
        }
        setcookie("DownCount", 1, time()+1,'/');
        $user_id = \Yii::$app->user->id ? \Yii::$app->user->id : 0;
        $params = \Yii::$app->request->post();
        $params['u_id'] = $user_id;

        if(isset($params['widget_id'])){
            //给项目添加下载次数
            $model = Widget::findOne($params['widget_id']);
            $model->down_count = intval($model->down_count) + 1;
            $params['down_url'] = $model->download;

            //作者本人下载不收积分
            if($model->u_id !== $user_id){
                //判断当前用户是否已下载过
                if(UserDownRecord::find()->where(['widget_id'=>$params['widget_id'],'u_id'=>$user_id])->count() == 0){
                    //给下载用户减去积分
                    $returnVal = UserScope::insertUpdate(-$model->down_money);
                    if(Json::decode($returnVal)['code'] == 100001){
                        return $returnVal;
                    };

                    //增加下载用户积分记录
                    UserScopeRecord::insetUpdate(['u_id'=>$user_id,'type'=>3,'widget_id'=>$params['widget_id'],'scope'=>-$model->down_money]);

                    //给组件作者增加积分
                    if(UserDownRecord::find()->where(['widget_id'=>$params['widget_id']])->count() <= 100){
                        UserScope::insertUpdate($model->down_money,$model->u_id);
                    }
                    //给组件作者增加积分记录
                    UserScopeRecord::insetUpdate(['u_id'=>$model->u_id,'type'=>4,'widget_id'=>$params['widget_id'],'scope'=>$model->down_money]);


                    //给个人添加下载记录
                    UserDownRecord::insertUpdate($params);
                }
            }

            $data = [
                'download' => $model->download,
                'down_money' => $model->down_money
            ];
            if($model->save()){
                return Json::encode(['code'=>'100000','message'=>'操作成功','down-data'=>$data]);
            }
            return Json::encode(['code'=>'100001','message'=>'操作失败']);
        }
        return Json::encode(['code'=>'100001','message'=>'操作失败']);
    }


    //收集关注人数
    public function actionUserInfo(){
        $params = \Yii::$app->request->post();
        $type = $params['type']; //1为设置访问量  2设置关注的人数
        $model = UserInfo::findOne(['uid'=>$params['uid']]);
        if($type == 2){
            $guan_status = $params['status']; //关注状态 0取消关注 1已关注
            if($model){
                if($guan_status == 0){
                    $model->collect = $model->collect - 1;
                }
                if($guan_status == 1){
                    $model->collect = $model->collect + 1;
                }
            }else{
                $model = new UserInfo();
                $model->uid = $params['uid'];
                $model->collect = 1;
            }
        }
        $model->save();
        return Json::encode(['code'=>'100000','message'=>'操作成功']);
    }

    //收藏
    public function actionCollect(){
        if(isset($_COOKIE['timeout'])){
            setcookie("timeout", 1, time()+1,'/');
            return Json::encode(['code'=>'100002','message'=>'请不要频繁操作，1s后再试']);
        }
        setcookie("timeout", 1, time()+1,'/');
        $user_id = \Yii::$app->user->id ? \Yii::$app->user->id : 0;
        $params = \Yii::$app->request->post();
        if(!isset($params['widget_id'])){
            return '组件id存在';
        }
        $params['widget_id'] = intval($_POST['widget_id']);
        $params['u_id'] = $user_id;
        if(UserCollect::insertUpdate($params)){
            return Json::encode(['code'=>'100000','message'=>'操作成功']);
        }
        return Json::encode(['code'=>'100001','message'=>'操作失败']);
    }

    //关注
    public function actionGuanzhu(){
        if(isset($_COOKIE['Guanzhu'])){
            setcookie("Guanzhu", 1, time()+1,'/');
            return Json::encode(['code'=>'100002','message'=>'请不要频繁操作，1s后再试']);
        }
        setcookie("Guanzhu", 1, time()+1,'/');
        $user_id = \Yii::$app->user->id ? \Yii::$app->user->id : 0;
        $params = \Yii::$app->request->post();
        $params['u_id'] = $user_id;
        if(UserGuanzhu::insertUpdate($params)){
            return Json::encode(['code'=>'100000','message'=>'操作成功']);
        }
        return Json::encode(['code'=>'100001','message'=>'操作失败']);
    }

    //评论
    public function actionPinglun(){
        if(isset($_COOKIE['pinglun'])){
            setcookie("pinglun", 1, time()+1,'/');
            return Json::encode(['code'=>'100002','message'=>'请不要频繁操作，1s后再试']);
        }
        setcookie("pinglun", 1, time()+1,'/');

        $params = \Yii::$app->request->post();
        $params['content'] =  '<pre>'.Html::encode($params['content']).'</pre>';
        $params['create_time'] = date('Y-m-d H:i:s');
        $params['uid'] = \Yii::$app->user->id;
        $member = Member::find()->where(['id'=>$params['uid']])->select(['username','avatar','id'])->asArray()->one();
        $params = array_merge($params,$member);
        $model = new Pinglun();
        $model->setAttributes($params);
        if($model->save()){
            return Json::encode(['code'=>'100000','message'=>'操作成功']);
        }
        return Json::encode(['code'=>'100001','message'=>'操作失败']);
    }

    //demo演示
    public function actionDemo(){
        $params =\Yii::$app->request->get();
        $unit_id = isset($params['widget_id']) ? $params['widget_id'] : "";
        if(!$unit_id){
            return "当前项目不存在";
        };
        $widget = Widget::find()->where(['widget.id'=>$unit_id])->asArray()->one();
        return $this->renderPartial('demo',compact('widget'));
    }
    
    //定制服务
    public function actionDingzhi(){

        $dingzhi_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(\Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            $dingzhi_id2 = MadeToOrder::insertUpdate($params,$dingzhi_id);
            if($dingzhi_id2){
                if($dingzhi_id){
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
                }
                $this->sendsMail('组件定制服务通知','<div style="font-family: \'Microsoft YaHei\';">
                    联系人姓名：<b>'.$params["username"].'</b></br>
                    联系人电话：<b>'.$params["tel"].'</b></br>
                    定制标题：<b>'.$params["title"].'</b></br>
                    定制内容：<b>'.$params["desc"].'</b></br>
                </div>');
                return Json::encode(array('code'=>'100000','message'=>'定制成功，我们会尽快与您联系！'));
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }
        //查询banner数据
        if($dingzhi_id){
            $data = MadeToOrder::find()->where(['id'=>$dingzhi_id])->asArray()->one();
            if(!$data){
                return '定制组件不存在';
            }
        }
        return $this->render('dingzhi',compact('data'));
    }
}