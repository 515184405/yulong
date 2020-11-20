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

    public static function setWaterUrl($params){

        // 普通水印
        $waterType1 = [
            '1' => 'g_nw', // 左上
            '2' => 'g_ne', // 右上
            '3' => 'g_sw', // 左下
            '4' => 'g_se', // 右下
        ];
        // 边栏水印
        $waterType2 = [
            '1' => 'g_north', // 上
            '2' => 'g_east',  // 右
            '3' => 'g_south', // 下
            '4' => 'g_west',  // 左
        ];

        $result = '?x-oss-process=image/auto-orient,1';

        foreach ($params as $key=>$val) {
            $w = $val->width; // 水印图百分比宽度
            $opacity = $val->opacity;  // 水印图透明度
            $padding = $val->padding;  // 距离上下左右侧的距离
            $water_type = $val->type;  // 水印类型 1为普通水印 2为边栏水印
            $position = $val->position;// 水印图位置
            $water_src = $val->imgsrc; // 水印图地址

            if(!$water_src){
                continue;
            }

            // 水印图前缀
            $water_img_perfix = '/watermark,bucket_'.Yii::$app->params['oss']['bucket'];

            // 水印图地址
            $water_img_src = ',image_';

            if($water_type == 1){
                $waterType = $waterType1;
            }else{
                $waterType = $waterType2;
            }
            // 水印图位置
            $water_img_location = ','.$waterType[$position];

            // 水印图百分比(水印图大小)
            // x-oss-process=image/resize,P_27   27为百分比宽度
            $water_img_w = self::urlsafe_b64encode($water_src.'?x-oss-process=image/resize,P_'.$w);
            // 水印透明度
            $water_img_opacity = ',t_'.$opacity;

            // 水印图x距离
            $water_img_x = ',x_'.$padding;

            // 水印图y距离
            $water_img_y = ',y_'.$padding;

            // 结果拼接
            $result .= $water_img_perfix.$water_img_src.$water_img_w.$water_img_location.$water_img_opacity.$water_img_x.$water_img_y;
        }

        return self::convertJson('100000','水印图片创建成功',$result);
    }
}
