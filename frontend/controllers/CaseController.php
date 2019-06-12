<?php
    namespace frontend\controllers;

use common\models\Cases;
use common\models\CaseTagJoin;
use common\models\CaseType;
use common\models\News;
use common\models\Widget;
use yii\data\Pagination;
use yii\web\Controller;

class CaseController extends CommonController {

    public function actionIndex(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
        // 通过tag_id反查出case_id
        $caseTagJoin = CaseTagJoin::find()->where(['tag_id'=>$tag_id])->asArray()->all();
        $limit = 20; //每页显示20条
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if($tag_id){
            $case = [];
            foreach ($caseTagJoin as $val){
                $case_item = Cases::find()->andFilterWhere(['id'=>$val['case_id']])->asArray()->one();
                array_push($case,$case_item);
            }
        }else{
            $case = Cases::find()->andFilterWhere(['type_id'=>$id])->asArray()->all();
        }

        $pagination = new Pagination(['totalCount' => count($case),'pageSize' => $limit]);
        $case = array_slice($case,$limit*($page-1),$limit);
        $type = CaseType::find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'case',
            'case' => $case,
            'pagination' => $pagination
        );
        return $this->renderPartial('index',compact('data'));
    }

    public function actionItem(){
        $params =\Yii::$app->request->get();
        $case_id = isset($params['case_id']) ? $params['case_id'] : "";
        $case_item = Cases::find()->joinWith('tag_join')->where(['cases.id'=>$case_id])->asArray()->one();

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
        );
        return $this->renderPartial('item',compact('data','case_id'));
    }
}