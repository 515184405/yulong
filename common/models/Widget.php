<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "widget".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string $banner_url
 * @property string $type 组件类型
 * @property string $source 作品来源
 * @property string $rule 作品使用描述
 * @property string $look 点击率
 * @property string $collect 收藏
 * @property string $download 下载地址
 * @property string $website 官网地址
 * @property string $down_count 下载次数
 * @property string $recommend 推荐
 */
class Widget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'widget';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'required'],
            [['desc', 'rule'], 'string'],
            [['look', 'collect', 'down_count','create_time','recommend','issue'], 'integer'],
            [['title', 'banner_url', 'type', 'source', 'download', 'website'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'banner_url' => 'Banner Url',
            'type' => 'Type',
            'source' => 'Source',
            'rule' => 'Rule',
            'look' => 'Look',
            'collect' => 'Collect',
            'download' => 'Download',
            'website' => 'Website',
            'down_count' => 'Down Count',
            'create_time' => 'Create Time',
            'recommend' => 'Recommend',
            'issue' => "Issue",
        ];
    }

    //查询推荐组件
    public static function recommend(){
        return Widget::find()->where(['and',['recommend'=>1],['issue'=>2]])->orderBy('id',SORT_DESC)->limit(3)->asArray()->all();
    }

    /*查数据*/
    public static function search($params){
        $query = static::find();
        //按title查找
        if(isset($params['title'])){
            $query->andFilterWhere(['and',['like','Widget.title',$params['title']],['issue'=>2]]);
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

    public static function insertUpdate($params,$widget_id = null){
        $model = new static();
        $params['create_time'] = time();
        if($widget_id){
            $model = $model::findOne($widget_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$widget_id) {
                return $model->attributes['id'];
            }
            return $widget_id;
        };
        return false;
    }
}
