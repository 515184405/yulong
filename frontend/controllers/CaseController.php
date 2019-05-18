<?php
    namespace frontend\controllers;

use common\models\Cases;
use common\models\CaseTagJoin;
use common\models\CaseType;
use common\models\News;
use common\models\Widget;
use yii\web\Controller;

class CaseController extends Controller{

    public function actionIndex(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
        // 通过tag_id反查出case_id
        $caseTagJoin = CaseTagJoin::find()->where(['tag_id'=>$tag_id])->asArray()->all();
        if($tag_id){
            $case = [];
            foreach ($caseTagJoin as $val){
                $case_item = Cases::find()->andFilterWhere(['id'=>$val['case_id']])->asArray()->one();
                array_push($case,$case_item);
            }
        }else{
            $case = Cases::find()->andFilterWhere(['type_id'=>$id])->asArray()->all();
        }
        $type = CaseType::find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'case',
            'case' => $case
        );
        return $this->renderPartial('index',compact('data'));
    }

    public function actionItem(){
        $params =\Yii::$app->request->get();
        $case_id = isset($params['case_id']) ? $params['case_id'] : "";
        $case_item = Cases::find()->joinWith('tag_join')->where(['Cases.id'=>$case_id])->asArray()->one();

        //查询推荐组件
        $recommend_widget = Widget::recommend();
        //查询推荐新闻
        $recommend_news = News::recommend();
        //查询推荐案例
        $recommend_case = Cases::recommend();
        //查询上-篇文章
        $prev_article = Cases::find()->andFilterWhere(['<', 'id', $case_id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        //查询下-篇文章
        $next_article = Cases::find()->andFilterWhere(['>', 'id', $case_id])->orderBy(['id' => SORT_ASC])->limit(1)->one();
        if(!$case_item){
            return '项目不存在';
        }
        $data = array(
            'link' => 'case',
            'prev' => $prev_article,
            'next' => $next_article,
            'data' => $case_item,
            'recommend_news' => $recommend_news,
            'recommend_case' => $recommend_case,
            'recommend_widget' => $recommend_widget
        );
        return $this->renderPartial('item',compact('data','case_id'));
    }
}