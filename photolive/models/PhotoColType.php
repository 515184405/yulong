<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_col_type".
 *
 * @property int $id
 * @property int $type 0 为四列 1为三列 2为两列
 * @property string $createtime
 * @property int $project_id 相册id
 */
class PhotoColType extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_col_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'project_id'], 'integer'],
            [['createtime', 'project_id'], 'required'],
            [['createtime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'createtime' => 'Createtime',
            'project_id' => 'Project ID',
        ];
    }
}
