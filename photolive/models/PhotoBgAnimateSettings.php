<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_bg_animate_settings".
 *
 * @property int $id
 * @property string $name 动画名称
 * @property int $type 0 为用户上传 1 为系统默认
 * @property string $images 用户上传的背景图动画icon
 * @property string $createtime
 * @property int $project_id
 * @property int $bg_id 系统配置id , 0为自定义
 */
class PhotoBgAnimateSettings extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_bg_animate_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'project_id', 'bg_id'], 'integer'],
            [['createtime'], 'required'],
            [['createtime'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['images'], 'string', 'max' => 1000],
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
            'type' => 'Type',
            'images' => 'Images',
            'createtime' => 'Createtime',
            'project_id' => 'Project ID',
            'bg_id' => 'Bg ID',
        ];
    }
}
