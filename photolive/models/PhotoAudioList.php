<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_audio_list".
 *
 * @property int $id
 * @property int $type 0为系统，1为用户上传
 * @property string $createtime
 * @property string $src 音频地址
 * @property string $name 音频名称
 */
class PhotoAudioList extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_audio_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['createtime', 'src'], 'required'],
            [['createtime'], 'safe'],
            [['src'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 100],
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
            'createtime' => 'Createtime',
            'src' => 'Src',
            'name' => 'Name',
        ];
    }
}
