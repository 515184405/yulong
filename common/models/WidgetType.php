<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "widget_type".
 *
 * @property int $type_id
 * @property string $title
 */
class WidgetType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'widget_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }
}
