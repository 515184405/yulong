<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_audio_setting".
 *
 * @property int $id
 * @property string $createtime
 * @property int $project_id 音频地址
 * @property string $audio_id 关联的音频id
 * @property int $random 0 为顺序 1为随机
 */
class PhotoAudioSetting extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_audio_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'project_id'], 'required'],
            [['createtime'], 'safe'],
            [['project_id', 'random'], 'integer'],
            [['audio_id'], 'string', 'max' => 255],
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
            'audio_id' => 'Audio ID',
            'random' => 'Random',
        ];
    }
}
