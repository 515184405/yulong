<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $desc 简介
 * @property string $create_time 创建时间
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
            [['create_time'], 'safe'],
            [['look', 'issue'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 300],
            [['desc'], 'string', 'max' => 500],
            [['type_id', 'tag_id', 'sourse'], 'string', 'max' => 100],
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
            'look' => 'Look',
            'type_id' => 'Type ID',
            'tag_id' => 'Tag ID',
            'sourse' => 'Sourse',
            'content' => 'Content',
            'issue' => 'Issue',
        ];
    }
}
