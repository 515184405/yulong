<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_water_settings".
 *
 * @property int $id
 * @property string $createtime 创建时间
 * @property int $project_id 项目id
 * @property int $type 水印类型 1为普通水印 2为边栏水印
 * @property int $position 水印位置
 * @property int $width 水印宽度 百分比
 * @property int $padding 水印边距
 * @property int $opacity 水印透明度
 * @property int $status 水印状态  0为禁用 1为正常 
 * @property int $water_id
 */
class PhotoWaterSettings extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_water_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'project_id'], 'required'],
            [['createtime'], 'safe'],
            [['project_id', 'type', 'position', 'width', 'padding', 'opacity', 'status', 'water_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createtime' => 'Createtime',
            'project_id' => 'Project ID',
            'type' => 'Type',
            'position' => 'Position',
            'width' => 'Width',
            'padding' => 'Padding',
            'opacity' => 'Opacity',
            'status' => 'Status',
            'water_id' => 'Water ID',
        ];
    }
    public function getWaterArr(){
        return $this->hasOne(PhotoWaterArray::className(),['id'=>'water_id']);
    }
}
