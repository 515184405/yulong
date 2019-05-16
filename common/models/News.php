<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $desc 简介
 * @property int $create_time 创建时间
 * @property string $banner_url
 * @property int $look 点击率
 * @property string $type_id 类型
 * @property string $tag_id 标签
 * @property string $sourse 来源
 * @property string $content 内容
 * @property int $issue 是否发布
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc', 'content'], 'string'],
            [['create_time', 'look', 'issue','recommend'], 'integer'],
            [['title', 'banner_url', 'tag_id', 'sourse'], 'string', 'max' => 255],
            [['type_id'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'create_time' => 'Create Time',
            'banner_url' => 'Banner Url',
            'look' => 'Look',
            'type_id' => 'Type ID',
            'tag_id' => 'Tag ID',
            'sourse' => 'Sourse',
            'content' => 'Content',
            'issue' => 'Issue',
            'recommend' => 'Recommend',
        ];
    }
    /*关联newsTagJoin*/

    public function getNews_tag_join(){
        return $this->hasMany(NewsTagJoin::className(),['news_id'=>'id'])->with('newsTag');
    }
    /*关联case_type*/
    public function getNewsType(){
        return $this->hasOne(NewsType::className(),['type_id' => 'type_id']);
    }

    /*删除数据*/
    public static function deletes($id){
        News::deleteAll(['id'=>$id]);
    }

    //查询推荐新闻
    public static function recommend(){
        return News::find()->where(['recommend'=>1,'issue'=>2])->orderBy('id',SORT_DESC)->limit(3)->asArray()->all();
    }

    /*查数据*/
    public static function search($params){
        $query = static::find();
        //按title查找
        if(isset($params['title'])){
            $query->andFilterWhere(['like','news.title',$params['title']]);
        }
        $page = isset($params['page']) ? $params['page'] : '';
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->joinWith('newsType')->orderBy(['id' => SORT_DESC])->asArray()->all();
        return compact('count', 'list');
    }

    public static function insertUpdate($params,$news_id = null){
        $model = new static();
        $params['create_time'] = time();
        $content = strip_tags($params['content']);
        $params['desc'] = mb_substr($content,0,100);
        if($news_id){
            $model = $model::findOne($news_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$news_id) {
                return $model->attributes['id'];
            }
            return $news_id;
        };
        return false;
    }
}
