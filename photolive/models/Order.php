<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id 订单id
 * @property int $u_id 用户id
 * @property int $good_id 商品id
 * @property string $createtime 创建时间
 * @property int $count 订单数量
 * @property int $status 订单状态 0 已加入购物车 1已购买
 */
class Order extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'good_id', 'createtime'], 'required'],
            [['u_id', 'good_id', 'count', 'status'], 'integer'],
            [['createtime'], 'safe'],
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
            'good_id' => 'Good ID',
            'createtime' => 'Createtime',
            'count' => 'Count',
            'status' => 'Status',
        ];
    }
}
