<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_down_record".
 *
 * @property int $id
 * @property int $widget_id 项目id
 * @property string $create_time 下载时间
 * @property string $down_title 下载标题
 * @property int $

u_id
 */
class UserDownRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_down_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['widget_id', 'create_time', 'down_title', 'u_id'], 'required'],
            [['widget_id', 'u_id'], 'integer'],
            [['create_time'], 'safe'],
            [['down_title'], 'string', 'max' => 100],
            [['down_url'], 'string', 'max' => 255],
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
            'create_time' => 'Create Time',
            'down_title' => 'Down Title',
            'u_id' => 'U ID',
            'down_url' => 'Down Url',
        ];
    }

    //联查member表
    public function getMember(){
        return $this->hasOne(Member::className(),['id'=>'u_id'])->select(['id','username','province','city','avatar']);
    }

    //数据查询
    public static function search($params){
        $query = static::find();
        //按title查找
        if(isset($params['u_id'])){
            $query->andFilterWhere(['u_id' => $params['u_id']]);
        }
        $page = isset($params['page']) ? $params['page'] : '';
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->joinWith('member')->orderBy(['id' => SORT_DESC])->asArray()->all();
        return compact('count', 'list');
    }

    /*数据存与改*/
    public static function insertUpdate($params){
        $model = new static();
        $params['create_time'] = date("Y-m-d H:i:s",time());
        $modelOne = $model::findOne(['widget_id'=>$params['widget_id']]);
        if($modelOne){
            $model = $modelOne;
        }
        $model->setAttributes($params);
        if($model->save()){
            return true;
        };
        return false;
    }
}
