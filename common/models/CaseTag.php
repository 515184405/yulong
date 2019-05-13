<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "case_tag".
 *
 * @property int $tag_id
 * @property string $title
 * @property string $case_id
 */
class CaseTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'case_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'title' => 'Title',
            'case_id' => 'Case ID',
        ];
    }

    //插入数据
    public function insetData($data,$case_id){
        $tagStr = '';
        foreach ($data as $val){
            $model = new static();
            $model->setAttributes(['title' => $val,'case_id'=>strval($case_id)]);
            if($model->save()){
                $tagStr .= $model->attributes['tag_id'] . ',';
            };
        }
        return $tagStr;
    }
}
