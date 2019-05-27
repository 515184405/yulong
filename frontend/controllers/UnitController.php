<?php
namespace frontend\controllers;

use common\models\Cases;
use common\models\News;
use common\models\Widget;
use common\models\WidgetType;
use yii\helpers\Json;
use yii\web\Controller;

class UnitController extends CommonController {

    public function actionIndex(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $unitData = Widget::find()->orderBy(['id'=>SORT_DESC])->where(['issue'=>2])->asArray()->all();
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

        $type = WidgetType::find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'unit',
            'unit' => $unit
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
            $widget_item = Widget::find()->where(['and',['id'=>$unit_id],['issue'=>'2']])->asArray()->one();
        }
        //点击率加1
        $widget_item_look = Widget::findOne($unit_id);
        if(!$widget_item){
            return '项目不存在';
        }
        $widget_item_look->look = intval($widget_item_look->look) + 1;
        $widget_item_look->save();

        //查询上-篇文章
        $prev_article = Widget::find()->andFilterWhere(['and',['<', 'id', $unit_id],['issue'=>2]])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        //查询下-篇文章
        $next_article = Widget::find()->andFilterWhere(['and',['>', 'id', $unit_id],['issue'=>2]])->orderBy(['id' => SORT_ASC])->limit(1)->one();
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
        return $this->render('dingzhi');
    }
}