<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_sign".
 *
 * @property int $id
 * @property int $u_id 用户id
 * @property int $sign_count 连续签到次数
 * @property string $last_change_time 最后一次签到时间
 * @property string $sign_history 签到历史时间 以逗号隔开
 * @property int $count 签到次数
 * @property int $score
 */
class UserSign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_sign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'last_change_time', 'sign_history', 'count', 'score'], 'required'],
            [['u_id', 'sign_count', 'count', 'score'], 'integer'],
            [['last_change_time'], 'safe'],
            [['sign_history'], 'string', 'max' => 255],
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
            'sign_count' => 'Sign Count',
            'last_change_time' => 'Last Change Time',
            'sign_history' => 'Sign History',
            'count' => 'Count',
            'score' => 'Score',
        ];
    }
}
