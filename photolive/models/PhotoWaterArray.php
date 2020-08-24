<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_water_array".
 *
 * @property int $id
 * @property string $createtime 创建时间
 * @property string $imgsrc 水印图片
 * @property int $project_id
 */
class PhotoWaterArray extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_water_array';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'imgsrc', 'project_id'], 'required'],
            [['createtime'], 'safe'],
            [['project_id'], 'integer'],
            [['imgsrc'], 'string', 'max' => 255],
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
            'imgsrc' => 'Imgsrc',
            'project_id' => 'Project ID',
        ];
    }
}
