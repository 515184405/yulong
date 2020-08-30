<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_cover_settings".
 *
 * @property int $id 启动页id
 * @property int $type 启动页类型 1封面图 2封面为相册详情页
 * @property string $cover_image_url 封面图
 * @property int $count_time_status 封面倒计时状态  1开启 0关闭
 * @property int $count_time 倒计时时间
 * @property int $enter_btn_status 封面按钮状态 1为开启 0为关闭
 * @property string $enter_btn 封面按钮文字
 * @property int $enter_btn_type 1方形按钮 2为椭圆形按钮 3为通栏按钮
 * @property int $enter_btn_bottom 按钮距离底部距离
 * @property string $enter_btn_color
 * @property string $enter_ani 进入动画类名
 * @property int $project_id
 * @property string $createtime 创建时间
 */
class PhotoCoverSettings extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_cover_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'count_time_status', 'count_time', 'enter_btn_status', 'enter_btn_type', 'enter_btn_bottom', 'project_id'], 'integer'],
            [['project_id', 'createtime'], 'required'],
            [['createtime'], 'safe'],
            [['cover_image_url'], 'string', 'max' => 255],
            [['enter_btn', 'enter_btn_color', 'enter_ani'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'cover_image_url' => 'Cover Image Url',
            'count_time_status' => 'Count Time Status',
            'count_time' => 'Count Time',
            'enter_btn_status' => 'Enter Btn Status',
            'enter_btn' => 'Enter Btn',
            'enter_btn_type' => 'Enter Btn Type',
            'enter_btn_bottom' => 'Enter Btn Bottom',
            'enter_btn_color' => 'Enter Btn Color',
            'enter_ani' => 'Enter Ani',
            'project_id' => 'Project ID',
            'createtime' => 'Createtime',
        ];
    }
}
