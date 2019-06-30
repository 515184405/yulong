<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pinglun".
 *
 * @property int $id
 * @property int $widget_id 组件ID
 * @property int $uid 用户id
 * @property string $username 用户名
 * @property string $avatar 用户头像
 * @property string $create_time 评论时间
 * @property int $parent_id 评论类型，父评论ID
 * @property string $content 评论内容
 */
class Pinglun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pinglun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['widget_id', 'uid', 'username', 'avatar', 'create_time', 'content'], 'required'],
            [['widget_id', 'uid', 'parent_id'], 'integer'],
            [['create_time'], 'safe'],
            [['username', 'avatar'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 3000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'widget_id' => 'Widget ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'avatar' => 'Avatar',
            'create_time' => 'Create Time',
            'parent_id' => 'Parent Id',
            'content' => 'Content',
        ];
    }
}
