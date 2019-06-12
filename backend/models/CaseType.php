<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "case_type".
 *
 * @property int $type_id
 * @property string $title
 * @property string $case_id
 */
class CaseType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id'], 'integer'],
            [['title', 'case_id'], 'string', 'max' => 255],
            [['type_id'], 'unique'],
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
            'case_id' => 'Case ID',
        ];
    }
}
