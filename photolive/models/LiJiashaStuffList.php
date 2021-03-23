<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "li_jiasha_stuff_list".
 *
 * @property int $id id
 * @property string $daytime
 * @property string $createtime 日期
 * @property double $lg_car 大车数量
 * @property double $xs_car 小车
 * @property string $beizhu 备注
 * @property int $u_id
 * @property string $updatetime
 * @property double $total 小计
 */
class LiJiashaStuffList extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'li_jiasha_stuff_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['daytime', 'createtime', 'u_id', 'updatetime'], 'required'],
            [['daytime', 'createtime', 'updatetime'], 'safe'],
            [['lg_car', 'xs_car', 'total'], 'number'],
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
            'lg_car' => 'Lg Car',
            'xs_car' => 'Xs Car',
            'beizhu' => 'Beizhu',
            'u_id' => 'U ID',
            'updatetime' => 'Updatetime',
            'total' => 'Total',
        ];
    }
}
