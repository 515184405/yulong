<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_order".
 *
 * @property int $id
 * @property string $no 订单编号
 * @property string $createtime 创建时间
 * @property int $u_id 下单人id
 * @property int $good_id 商品id
 * @property int $project_id 项目id
 * @property int $status 0未付款 ， 1正常使用，2已过期
 * @property string $paytime 付款时间
 */
class PhotoOrder extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no', 'createtime', 'u_id', 'good_id', 'project_id'], 'required'],
            [['createtime', 'paytime'], 'safe'],
            [['u_id', 'good_id', 'project_id', 'status'], 'integer'],
            [['no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No',
            'createtime' => 'Createtime',
            'u_id' => 'U ID',
            'good_id' => 'Good ID',
            'project_id' => 'Project ID',
            'status' => 'Status',
            'paytime' => 'Paytime',
        ];
    }
    public static function insertUpdate($params)
    {
        $model = new static();
        if($params['id']) {
            $message = '修改';
            $model = static::findOne($params['id']);
        }else{
            $message = '添加';
            $params['createtime'] = date('Y-m-d H:i:s',time());
        }
        $model->setAttributes($params);
        $result = null;
        if($model->save()){
            //$result = $model->attributes;
            return self::convertJson('100000',$message.'成功',$result);
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001',$message.'失败',$result);
        }
    }
}
