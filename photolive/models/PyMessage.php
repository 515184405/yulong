<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "py_message".
 *
 * @property int $id 人员id
 * @property int $u_id 主操作员id
 * @property int $project_id 相册id
 * @property string $project_name 相册名称
 * @property string $phone
 * @property string $username
 * @property int $status 是否联系 0为否 1为是
 * @property string $createtime 创建时间
 */
class PyMessage extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'py_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'project_id', 'project_name', 'phone', 'username', 'createtime'], 'required'],
            [['u_id', 'project_id', 'status'], 'integer'],
            [['createtime'], 'safe'],
            [['project_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
            [['username'], 'string', 'max' => 50],
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
            'project_id' => 'Project ID',
            'project_name' => 'Project Name',
            'phone' => 'Phone',
            'username' => 'Username',
            'status' => 'Status',
            'createtime' => 'Createtime',
        ];
    }
}
