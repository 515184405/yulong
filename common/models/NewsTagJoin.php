<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_tag_join".
 *
 * @property int $id
 * @property int $tag_id
 * @property int $news_id
 */
class NewsTagJoin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_tag_join';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'news_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'news_id' => 'News ID',
        ];
    }

    /*关联newsTag*/
    public function getNewsTag(){
        return $this->hasOne(NewsTag::className(),['tag_id'=>'tag_id']);
    }

    //删除数据
    public static function deletes($id){
        CaseTagJoin::deleteAll(['news_id'=>$id]);
    }

    public static function insertUpdate($tag_id,$news_id){
        $models = new static();
        $models::deleteAll('news_id in('.$news_id.')');
        foreach ($tag_id as $item) {
            $model = new static();
            $model->setAttributes(['tag_id' => $item, 'news_id' => $news_id]);
            $model->save();
        }
    }
}
