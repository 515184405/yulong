<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string $banner_url
 * @property int $sort
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banner_url', 'sort'], 'required'],
            [['sort'], 'integer'],
            [['banner_url','desc','url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_url' => 'Banner Url',
            'sort' => 'Sort',
            'desc' => 'Desc',
            'url' => 'Url',
        ];
    }
    //查询与搜索
    public static function search($params){
        $query = static::find();
        $limit = isset($params['limit']) ? $params['limit'] :'';
        $page = isset($params['page']) ? $params['page'] :'';
        $count = 0;
        if($limit && $page){
            $offset = $limit * ($page - 1);
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $data = $query->orderBy(['sort'=>SORT_ASC])->asArray()->all();
        return compact('count','data');
    }

//    添加与修改
    public static function insertUpdate($params,$banner_id = null){
        $model = new static();
        $params['sort'] = is_null($params['sort']) ? $params['sort'] : 0;
        if($banner_id){
            $model = $model::findOne($banner_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$banner_id) {
                return $model->attributes['id'];
            }
            return $banner_id;
        };
        return false;
    }
}
