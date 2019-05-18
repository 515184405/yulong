<?php
namespace frontend\controllers;

use common\models\Cases;
use common\models\News;
use common\models\Widget;
use common\models\WidgetType;
use yii\helpers\Json;
use yii\web\Controller;

class UnitController extends Controller{

    public function actionIndex(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        $unitData = Widget::find()->where(['issue'=>2])->asArray()->all();
        $unit = [];
        foreach ($unitData as $item) {
            $item['type_tag'] = [];
            foreach (explode(',',$item['type']) as $type) {
                $typeModel = WidgetType::findOne($type);
                array_push($item['type_tag'],$typeModel->title);
                if($id){
                    if($type == $id){
                        array_push($unit,$item);
                    }
                }else{
                    array_push($unit,$item);
                }
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
        $unit_id = isset($params['widget_id']) ? $params['widget_id'] : "";
        $widget_item = Widget::find()->where(['and',['id'=>$unit_id],['issue'=>'2']])->asArray()->one();
        //点击率加1
        $widget_item_look = Widget::findOne($unit_id);
        if(!$widget_item_look){
            return '项目不存在';
        }
        $widget_item_look->look = intval($widget_item_look->look) + 1;
        $widget_item_look->save();

        //查询推荐新闻
        $recommend_news = News::recommend();
        //查询推荐组件
        $recommend_widget = Widget::recommend();
        //查询推荐案例
        $recommend_case = Cases::recommend();
        //查询上-篇文章
        $prev_article = Widget::find()->andFilterWhere(['and',['<', 'id', $unit_id],['issue'=>2]])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        //查询下-篇文章
        $next_article = Widget::find()->andFilterWhere(['and',['>', 'id', $unit_id],['issue'=>2]])->orderBy(['id' => SORT_ASC])->limit(1)->one();
        $data = array(
            'link' => 'unit',
            'prev' => $prev_article,
            'next' => $next_article,
            'data' => $widget_item,
            'recommend_news' => $recommend_news,
            'recommend_case' => $recommend_case,
            'recommend_widget' => $recommend_widget,
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
}