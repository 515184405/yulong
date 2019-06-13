<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_guanzhu".
 *
 * @property int $id
 * @property int $u_id
 * @property int $widget_id
 */
class UserGuanzhu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_guanzhu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id','other_id'], 'required'],
            [['u_id','other_id'], 'integer'],
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
            'other_id'=> 'Other ID'
        ];
    }

    /*数据存与改*/
    public static function insertUpdate($params){
        $model = new static();
        $modelOne = $model::findOne(['other_id'=>$params['other_id'],'u_id'=>$params['u_id']]);
        if($modelOne){
            static::deleteAll(['other_id' => $params['other_id'],'u_id'=>$params['u_id'] ]);
            return true;
        }else{
            $model->setAttributes($params);
            if($model->save()){
                return true;
            };
            return false;
        }
        return false;
    }
}
