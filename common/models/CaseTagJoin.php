<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "case_tag_join".
 *
 * @property int $id
 * @property int $tag_id
 * @property int $case_id
 */
class CaseTagJoin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_tag_join';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'case_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'case_id' => 'Case ID',
        ];
    }

    public function getTag_id(){
        return $this->hasOne(CaseTag::className(),['tag_id' => 'tag_id']);
    }

    //删除数据
    public static function deletes($id){
        CaseTagJoin::deleteAll(['case_id'=>$id]);
    }

    public function insertUpdate($cases_id,$caseTag_id){
        $models = new static();
        $oneModel = $models->findOne(['case_id'=>$cases_id]);
        if($oneModel){
            $models::deleteAll('case_id in('.$cases_id.')');
        }
        foreach ($caseTag_id as $val){
            $model = new static();
            $model->setAttributes(['tag_id' => $val, 'case_id' => $cases_id]);
            $model->save();
        };
    }
}
