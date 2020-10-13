<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_skin".
 *
 * @property int $id 样式id 
 * @property string $title 主题标题
 * @property string $bg_color 背景颜色
 * @property string $module_bg_color 模块背景颜色
 * @property string $bg_image 背景图片
 * @property string $color 文字颜色
 * @property string $active_color 文字选中颜色
 * @property string $createtime 创建时间
 * @property int $type 0 为系统类 1为用户配置
 * @property int $project_id u_id
 */
class PhotoSkin extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_skin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime'], 'required'],
            [['createtime'], 'safe'],
            [['type', 'project_id'], 'integer'],
            [['title', 'module_bg_color', 'bg_image'], 'string', 'max' => 255],
            [['bg_color', 'color', 'active_color'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'bg_color' => 'Bg Color',
            'module_bg_color' => 'Module Bg Color',
            'bg_image' => 'Bg Image',
            'color' => 'Color',
            'active_color' => 'Active Color',
            'createtime' => 'Createtime',
            'type' => 'Type',
            'project_id' => 'Project ID',
        ];
    }
}
