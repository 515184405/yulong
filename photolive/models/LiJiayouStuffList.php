<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "li_jiayou_stuff_list".
 *
 * @property int $id id
 * @property string $daytime
 * @property string $createtime 日期
 * @property double $price
 * @property double $liters 大车数量
 * @property string $beizhu 备注
 * @property int $u_id
 * @property string $updatetime
 * @property double $total 小计
 */
class LiJiayouStuffList extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'li_jiayou_stuff_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['daytime', 'createtime', 'price', 'u_id', 'updatetime'], 'required'],
            [['daytime', 'createtime', 'updatetime'], 'safe'],
            [['price', 'liters', 'total'], 'number'],
            [['u_id'], 'integer'],
            [['beizhu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'daytime' => 'Daytime',
            'createtime' => 'Createtime',
            'price' => 'Price',
            'liters' => 'Liters',
            'beizhu' => 'Beizhu',
            'u_id' => 'U ID',
            'updatetime' => 'Updatetime',
            'total' => 'Total',
        ];
    }
}
