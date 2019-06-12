<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload_form".
 *
 * @property int $id
 * @property string $src
 */
class UploadForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['src'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
        ];
    }
}
