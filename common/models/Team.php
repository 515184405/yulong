<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name 姓名
 * @property int $age 年龄
 * @property string $avatar 头像
 * @property int $exp 经验
 * @property string $profession 职业
 * @property int $is_true 0 未审核 1审核不通过 2通过
 * @property string $desc 简介
 * @property string $card 身份证号
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'age', 'avatar', 'exp', 'profession', 'is_true'], 'required'],
            [['age', 'exp', 'is_true','create_time'], 'integer'],
            [['desc'], 'string'],
            [['name', 'avatar', 'profession', 'card'], 'string', 'max' => 255],
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
            'age' => 'Age',
            'avatar' => 'Avatar',
            'exp' => 'Exp',
            'profession' => 'Profession',
            'is_true' => 'Is True',
            'desc' => 'Desc',
            'card' => 'Card',
            'create_time' => 'Create Time'
        ];
    }
    /*查数据*/
    public static function search($params){
        $query = static::find();
        //按title查找
        if(isset($params['name'])){
            $query->andFilterWhere(['like','team.name',$params['name']]);
        }
        $page = isset($params['page']) ? $params['page'] : '';
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->orderBy(['id' => SORT_DESC])->asArray()->all();
        return compact('count', 'list');
    }

    public static function insertUpdate($params,$news_id = null){
        $model = new static();
        $model->create_time = time();
        $model->is_true = 0;
        if($news_id){
            $model = $model::findOne($news_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$news_id) {
                return $model->attributes['id'];
            }
            return $news_id;
        };
        return false;
    }
}
