<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zixun".
 *
 * @property int $id
 * @property string $name
 * @property int $tel
 * @property string $email
 * @property string $content
 * @property int $create_time
 */
class Zixun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zixun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tel', 'email', 'content', 'create_time'], 'required'],
            [['tel', 'create_time','status'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 40],
            [['content'], 'string', 'max' => 255],
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
            'tel' => 'Tel',
            'email' => 'Email',
            'content' => 'Content',
            'create_time' => 'Create Time',
            'status' => 'status'
        ];
    }
    /*查数据*/
    public static function search($params){
        $query = static::find();
        //按title status查找
        if(isset($params['title'])){
            $query->andFilterWhere(['like','tel',$params['tel']]);
        }
        $page = isset($params['page']) ? $params['page'] : '';
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->orderBy(['create_time' => SORT_DESC])->asArray()->all();
        return compact('count', 'list');
    }

    //存与更新
    public static function insertUpdate($params,$zixun_id = null){
        $model = new static();
        $params['create_time'] = time();
        if($zixun_id){
            $model = $model::findOne($zixun_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$zixun_id) {
                return $model->attributes['id'];
            }
            return $zixun_id;
        };
        return false;
    }
}
