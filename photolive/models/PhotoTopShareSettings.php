<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_top_share_settings".
 *
 * @property int $id
 * @property string $top_image_url 顶部宣传图
 * @property int $type 类型  1为图片 2为视频
 * @property string $link 宣传图链接
 * @property string $createtime 创建时间
 * @property int $project_id 项目id
 * @property string $video_cover_src 视频地址
 * @property string $video_cover_image 视频封面图
 */
class PhotoTopShareSettings extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_top_share_settings';
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
            [['top_image_url', 'link', 'video_cover_src', 'video_cover_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'top_image_url' => 'Top Image Url',
            'type' => 'Type',
            'link' => 'Link',
            'createtime' => 'Createtime',
            'project_id' => 'Project ID',
            'video_cover_src' => 'Video Cover Src',
            'video_cover_image' => 'Video Cover Image',
        ];
    }
}
