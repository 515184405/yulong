<?php
namespace backend\controllers;

use common\models\News;
use common\models\NewsTag;
use common\models\NewsTagJoin;
use common\models\NewsType;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\LoginForm;

/**
 * Site controller
 */
class NewsController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //读数据
        $params = Yii::$app->request->get();
        if(Yii::$app->request->isAjax){
            $data = news::search($params);
            return $this->convertJson('0','查询成功',$data['list'], $data['count']);
        }
        return $this->render('index');
    }
    //创建文章
    public function actionInfo()
    {
        $news_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            $news_id2 = News::insertUpdate($params,$news_id);
            //存newsTagModel数据
            $newTagArr = explode(',',$params['tag_id']);
            $tag_id = NewsTag::insertUpdate($newTagArr);
            NewsTagJoin::insertUpdate($tag_id,$news_id2);
            if($news_id){
                return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
            }
            return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
        }
        //查类型数据
        $data['type'] = NewsType::find()->asArray()->all();
        //查询新闻数据
        if($news_id){
            $data['news'] = News::find()->joinWith(['news_tag_join'])->where(['News.id'=>$news_id])->asArray()->one();
            if(!$data['news']){
                return '新闻不存在';
            }
        }
        return $this->render('info',compact('data'));
    }
    //新增文章类型
    public function actionType()
    {
        $data = '';
        if(Yii::$app->request->isAjax) {
            $model = new NewsType();
            //获取POST内容
            $params = Yii::$app->request->post();
            $model->setAttributes($params);
            if($model->save()){
                return Json::encode(array('code'=>'100000','message'=>'添加成功！'));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
        }
        return $this->render('type');
    }

    //设置为推荐
    public function actionRecommend(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 1 : 0;
        $news = News::findOne($id);
        $news->recommend = $checked;
        if($news->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    //设置为发布状态
    public function actionIssue(){
        $checked = isset($_POST['checked']) ? $_POST['checked'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $checked = $checked == 'true' ? 2 : 1;
        $news = News::findOne($id);
        $news->issue = $checked;
        if($news->save()){
            return Json::encode(['code' => 100000,'message' => '设置成功']);
        }
        return Json::encode(['code' => 100000,'message' => '设置失败']);
    }

    public function actionDelete(){
        $newsid = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $newsid){
            News::deletes($newsid);
            NewsTagJoin::deletes($newsid);
            return Json::encode(['code' => 100000,'message' => '删除成功']);
        }else{
            return Json::encode(['code' => 100000,'message'=> '没有找到要删除的目标']);
        }
    }

    //图片上传
    public function actionUploadImage(){
        $uploadImage = $this->uploadImage();
        if(isset($uploadImage)){
            if($uploadImage['status']) {
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','data'=>array(
                    'fileName' => $uploadImage['fileName'],
                    'fileSrc' => '/'.$uploadImage['fileSrc']
                )));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
        }
    }
}