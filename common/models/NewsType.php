<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_type".
 *
 * @property int $type_id
 * @property string $title
 * @property string $news_id
 */
class NewsType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'title' => 'Title',
            'news_id' => 'News ID',
        ];
    }
}
