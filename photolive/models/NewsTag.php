<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "news_tag".
 *
 * @property int $tag_id
 * @property string $title
 * @property string $news_id
 */
class NewsTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'title' => 'Title',
        ];
    }

    /*存数据*/
    public static function insertUpdate($tagArr){
        $tagArrId = [];
        foreach ($tagArr as $item) {
            $model = new static();
            $oneModel = $model->find()->where(['title'=>$item])->one();
            if(!$oneModel){
                $model->setAttributes(['title'=>$item]);
                if($model->save()){
                    array_push($tagArrId,$model->attributes['tag_id']);
                };
            }else{
                array_push($tagArrId,$oneModel->attributes['tag_id']);
            }
        }
        return $tagArrId;
    }
}
