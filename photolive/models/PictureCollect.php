<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "picture_collect".
 *
 * @property int $id 相册类型id
 * @property int $u_id 用户id
 * @property string $createtime 创建时间
 * @property int $picture_id 图片id
 */
class PictureCollect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture_collect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'createtime', 'picture_id'], 'required'],
            [['u_id', 'picture_id'], 'integer'],
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
            'u_id' => 'U ID',
            'createtime' => 'Createtime',
            'picture_id' => 'Picture ID',
        ];
    }
}
