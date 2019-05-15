<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $desc 简介
 * @property int $create_time 创建时间
 * @property string $banner_url
 * @property int $look 点击率
 * @property string $type_id 类型
 * @property string $tag_id 标签
 * @property string $sourse 来源
 * @property string $content 内容
 * @property int $issue 是否发布
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc', 'content'], 'string'],
            [['create_time', 'look', 'issue'], 'integer'],
            [['title', 'banner_url', 'tag_id', 'sourse'], 'string', 'max' => 255],
            [['type_id'], 'string', 'max' => 11],
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
            'create_time' => 'Create Time',
            'banner_url' => 'Banner Url',
            'look' => 'Look',
            'type_id' => 'Type ID',
            'tag_id' => 'Tag ID',
            'sourse' => 'Sourse',
            'content' => 'Content',
            'issue' => 'Issue',
        ];
    }

    public static function insertUpdate($params,$news_id){
        if($news_id){

        }
        News::setAttributes($params);
        News::save();
    }
}
