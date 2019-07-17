<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_scope_record".
 *
 * @property int $id
 * @property int $widget_id
 * @property int $scope
 * @property int $u_id
 * @property int $created_time
 * @property int $type 0 新用户注册获得积分； 1 上传项目获得积分
 */
class UserScopeRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_scope_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['widget_id', 'scope', 'type','u_id'], 'integer'],
            [['created_time'], 'safe'],
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
            'scope' => 'Scope',
            'type' => 'Type',
            'u_id' => 'U Id',
            'created_time' => 'Created Time',
        ];
    }
}
