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
            [['title'], 'string', 'max' => 100],
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
        ];
    }

    //插入数据
    public function insertUpdate($data){
        $tagStr = [];
        foreach ($data as $val){
            $model = new static();
            $oneModel = $model->find()->where(['title'=>$val])->one();
            if(!$oneModel){
                $model->setAttributes(['title' => $val]);
                if($model->save()){
                    array_push($tagStr,$model->attributes['tag_id']);
                };
            }else{
                array_push($tagStr,$oneModel->attributes['tag_id']);
            }
        }
        return $tagStr;
    }
}
