<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "user_scope".
 *
 * @property int $id
 * @property int $uid 用户id
 * @property int $scope 用户积分
 */
class UserScope extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_scope';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'scope'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'scope' => 'Scope',
        ];
    }

    /**
     * 用户积分
     * @param int $scope
     * @param int $uid
     * @return string
     */
    public static function insertUpdate($scope = 0,$uid=0){
        $model = new static();
        $uid = $uid !== 0 ? $uid : Yii::$app->user->id;
        $oneModel = $model::findOne(['uid'=>$uid]);
        if($oneModel){
            $model = $oneModel;
            $scope = $scope + $oneModel->scope;
        }
        if($scope < 0){
            return Json::encode(['code'=>100001,'message'=>'积分不足']);
        }
        $model->uid = $uid;
        $model->scope = $scope;
        if($model->save()){
            return Json::encode(['code'=>100000,'message'=>'success']);
        };
        return Json::encode(['code'=>100001,'message'=>'error']);
    }
}
