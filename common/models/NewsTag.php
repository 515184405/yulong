<?php

namespace common\models;

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
            [['title', 'news_id'], 'string', 'max' => 100],
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
            'news_id' => 'News ID',
        ];
    }
}
