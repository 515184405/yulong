<?php
    namespace frontend\controllers;

use common\models\Cases;
use common\models\CaseTagJoin;
use common\models\CaseType;
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
//        var_dump($case_item);die;
        //查询上-篇文章
        $prev_article = Cases::find()->andFilterWhere(['<', 'id', $case_id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        //查询下-篇文章
        $next_article = Cases::find()->andFilterWhere(['>', 'id', $case_id])->orderBy(['id' => SORT_ASC])->limit(1)->one();
        if(!$case_item){
            return '项目不存在';
        }
        $data = array(
            'link' => 'case',
            'prev_id' => $prev_article['id'],
            'next_id' => $next_article['id'],
            'data' => $case_item
        );
        return $this->renderPartial('item',compact('data','case_id'));
    }
}