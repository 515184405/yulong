<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cases".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string $pc_link
 * @property string $wap_link
 * @property string $wx_link
 * @property int $create_time
 * @property string $banner_url
 * @property string $header_url
 * @property string $content_url
 * @property string $type_id
 * @property string $tag_id
 */
class Cases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time'], 'integer'],
            [['title', 'pc_link', 'wap_link', 'wx_link', 'banner_url', 'header_url', 'content_url', 'type_id', 'tag_id'], 'string', 'max' => 300],
            [['desc'], 'string', 'max' => 255],
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
            'desc' => 'Desc',
            'pc_link' => 'Pc Link',
            'wap_link' => 'Wap Link',
            'wx_link' => 'Wx Link',
            'create_time' => 'Create Time',
            'banner_url' => 'Banner Url',
            'header_url' => 'Header Url',
            'content_url' => 'Content Url',
            'type_id' => 'Type ID',
            'tag_id' => 'Tag ID',
        ];
    }
}
