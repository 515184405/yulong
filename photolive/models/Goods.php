<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id 商品id
 * @property string $name 商品名称
 * @property string $desc 商品介绍
 * @property int $price 商品价格
 * @property int $status 商品状态 0 未开启  1已开启
 * @property string $createtime 创建时间
 * @property string $imgsrc 商品图片
 * @property int $recommend 是否设为推荐
 * @property int $img_count 图片数量
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'desc', 'createtime','img_count'], 'required'],
            [['price', 'status', 'recommend','img_count'], 'integer'],
            [['createtime'], 'safe'],
            [['name', 'desc', 'imgsrc'], 'string', 'max' => 255],
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
            'desc' => 'Desc',
            'price' => 'Price',
            'status' => 'Status',
            'createtime' => 'Createtime',
            'imgsrc' => 'Imgsrc',
            'recommend' => 'Recommend',
            'img_count' => 'Img Count'
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
        $data = $query->orderBy(['id'=>SORT_ASC])->asArray()->all();
        return compact('count','data');
    }

//    添加与修改
    public static function insertUpdate($params,$banner_id = null){
        $model = new static();
        if($banner_id){
            $model = $model::findOne($banner_id);
        }else{
            $params['createtime'] = date('Y-m-d H:i:s',time());
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
