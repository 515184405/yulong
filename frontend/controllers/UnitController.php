<?php
namespace frontend\controllers;

use common\models\Cases;
use common\models\MadeToOrder;
use common\models\News;
use common\models\Widget;
use common\models\WidgetType;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Controller;

class UnitController extends CommonController {

    public function actionIndex(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $unitData = Widget::find()->orderBy(['id'=>SORT_DESC])->where(['status'=>1])->andFilterWhere(['like','title',$search])->orFilterWhere(['like','desc',$search])->asArray()->all();
        $limit = 20; //每页显示20条
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $unit = [];
        $is_true = false; //判断当前类型是否存在项目
        foreach ($unitData as $item) {
            $typeTitle = [];
            $is_true = false;
            foreach (explode(',',$item['type']) as $type) {
                $typeModel = WidgetType::findOne($type);
                array_push($typeTitle,$typeModel->title);
                if($type == $id && $is_true !== true){
                    $is_true = true; //当前类型中存在项目
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
            $widget_item = Widget::find()->where(['id'=>$unit_id])->asArray()->one();
        }else{
            //所有可见
            $widget_item = Widget::find()->where(['and',['id'=>$unit_id],['status'=>'1']])->asArray()->one();
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
        $data = array(
            'link' => 'unit',
            'prev' => $prev_article,
            'next' => $next_article,
            'data' => $widget_item,
        );
        return $this->renderPartial('item',compact('data','unit_id'));
    }

    public function actionDownCount(){
        $id = $_POST['id'];
        if(isset($id)){
            $model = Widget::findOne($id);
            $model->down_count = intval($model->down_count) + 1;
            if($model->save()){
                return Json::encode(['code'=>'100000','message'=>'操作成功']);
            }
            return Json::encode(['code'=>'100001','message'=>'操作失败']);
        }
        return Json::encode(['code'=>'100001','message'=>'操作失败']);
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
                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
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