<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_collect".
 *
 * @property int $id
 * @property int $.css<?=Yii::$app->params['static_number']?>"
 * @property int $widget_id
 */
class UserCollect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_collect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'widget_id'], 'required'],
            [['u_id', 'widget_id'], 'integer'],
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
            'widget_id' => 'Widget ID',
        ];
    }

    //联查member表
    public function getMember(){
        return $this->hasOne(Member::className(),['id'=>'other_id'])->select(['id','username','province','city','avatar']);
    }

    public function getCollect_widget(){
        return $this->hasOne(Widget::className(),['id'=>'widget_id'])->select(['id','title','desc','banner_url','type','look','collect','down_count','download','status','upload_download'])->orderBy(['id'=>SORT_DESC]);
    }

    /*数据存与改*/
    public static function insertUpdate($params){
        $model = new static();
        $modelOne = $model::findOne(['widget_id'=>$params['widget_id'],'u_id'=>$params['u_id']]);
        if($modelOne){
            static::deleteAll(['widget_id' => $params['widget_id'],'u_id'=>$params['u_id'] ]);
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
