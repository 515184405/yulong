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
}
