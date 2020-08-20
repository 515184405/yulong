<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_type".
 *
 * @property int $id 相册类型id
 * @property string $name 姓名类型名字
 */
class PhotoType extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','createtime'], 'required'],
            [['createtime'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'createtime' => 'Createtime'
        ];
    }
}
