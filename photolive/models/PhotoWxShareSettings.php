<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_wx_share_settings".
 *
 * @property int $id
 * @property string $share_image 微信分享图
 * @property string $createtime 创建时间
 * @property int $project_id 项目id
 * @property string $title 分享标题
 * @property string $desc 分享描述
 */
class PhotoWxShareSettings extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_wx_share_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'project_id'], 'required'],
            [['createtime'], 'safe'],
            [['project_id'], 'integer'],
            [['share_image', 'title', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_image' => 'Share Image',
            'createtime' => 'Createtime',
            'project_id' => 'Project ID',
            'title' => 'Title',
            'desc' => 'Desc',
        ];
    }
}
