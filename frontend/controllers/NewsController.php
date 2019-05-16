<?php
namespace frontend\controllers;

use common\models\Cases;
use common\models\News;
use common\models\NewsTagJoin;
use common\models\NewsType;
use yii\web\Controller;

class NewsController extends Controller{
    public function actionIndex(){
        //案列类型筛选id;
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        //标签筛选id;
        $tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
        // 通过tag_id反查出news_id
        $caseTagJoin = NewsTagJoin::find()->where(['tag_id'=>$tag_id])->asArray()->all();
        if($tag_id){
            $news = [];
            //获取标签筛选出来的案例结果列表
            foreach ($caseTagJoin as $val){
                $case_item = News::find()->joinWith(['newsType','news_tag_join'])->andFilterWhere(['News.id'=>$val['news_id']])->asArray()->one();
                array_push($news,$case_item);
            }
        }else{
            //获取类型筛选出来的案例结果列表
            $news = News::find()->joinWith(['newsType','news_tag_join'])->andFilterWhere(['News.type_id'=>$id,'issue'=>2])->asArray()->all();
        }
        $type = NewsType::find()->asArray()->all();
        $data = array(
            'type' => $type,
            'link' => 'news',
            'news' => $news
        );
        return $this->renderPartial('index',compact('data'));
    }
    public function actionItem(){
        $params =\Yii::$app->request->get();
        $news_id = isset($params['news_id']) ? $params['news_id'] : "";
        //点击率加1
        $news_item_look = News::findOne($news_id);
        if(!$news_item_look){
            return '项目不存在';
        }
        $news_item_look->look = intval($news_item_look->look) + 1;
        $news_item_look->save();

        $news_item = News::find()->joinWith(['newsType','news_tag_join'])->andFilterWhere(['News.id'=>$news_id])->asArray()->one();

        //查询推荐新闻
        $recommend_news = News::recommend();
        //查询推荐案例
        $recommend_case = Cases::recommend();

//        var_dump($news_item);die;
        //查询上-篇文章
        $prev_article = News::find()->andFilterWhere(['<', 'id', $news_id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        //查询下-篇文章
        $next_article = News::find()->andFilterWhere(['>', 'id', $news_id])->orderBy(['id' => SORT_ASC])->limit(1)->one();
        $data = array(
            'link' => 'news',
            'prev' => $prev_article,
            'next' => $next_article,
            'data' => $news_item,
            'recommend_news' => $recommend_news,
            'recommend_case' => $recommend_case,
        );
        return $this->renderPartial('item',compact('data','news_id'));
    }
}