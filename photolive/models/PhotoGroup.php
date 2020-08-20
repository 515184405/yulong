<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_group".
 *
 * @property int $id 相册类型id
 * @property string $name 姓名类型名字
 * @property string $createtime 创建时间
 * @property int $sort 排序
 * @property int $project_id 项目id
 */
class PhotoGroup extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'createtime', 'project_id'], 'required'],
            [['createtime'], 'safe'],
            [['sort', 'project_id'], 'integer'],
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
            'createtime' => 'Createtime',
            'sort' => 'Sort',
            'project_id' => 'Project ID',
        ];
    }
}
