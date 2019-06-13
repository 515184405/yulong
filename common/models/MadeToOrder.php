<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "made_to_order".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property int $u_id
 * @property string $tel
 * @property string $username
 * @property string $file_url
 */
class MadeToOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'made_to_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'desc', 'u_id', 'tel', 'username', 'file_url','create_time'], 'required'],
            [['desc'], 'string'],
            [['u_id','create_time','status','money','widget_id'], 'integer'],
            [['title', 'file_url'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 15],
            [['username'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'u_id' => 'U ID',
            'tel' => 'Tel',
            'username' => 'Username',
            'file_url' => 'File Url',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'money' => 'Money',
            'widget_id' => 'Widget Id',
        ];
    }

    public function getProject_join(){
        return $this->hasOne(Widget::className(),['id' => 'widget_id'])->select(['id','title','desc','banner_url','download','status']);
    }

    /*待定制数据*/
    public static function dingZhiStatus(){
        return static::find()->where(['status'=>0])->asArray()->count();
    }

    //查询与搜索
    public static function search($params){
        $query = static::find();
        $status = isset($params['status']) ? $params['status'] : '';
        //按title status查找
        $query->andFilterWhere(['=','status',$status]);
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $page = isset($params['page']) ? $params['page'] :'';
        $count = 0;
        if($limit && $page){
            $offset = $limit * ($page - 1);
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $data = $query->orderBy(['id'=>SORT_DESC])->asArray()->all();
        return compact('count','data');
    }

    //    添加与修改
    public static function insertUpdate($params,$dingzhi_id = null){
        $model = new static();
        $params['create_time'] = time();
        $params['u_id'] = 0;  //添加登录后改成登录用户的uid
        if($dingzhi_id){
            $model = $model::findOne($dingzhi_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$dingzhi_id) {
                return $model->attributes['id'];
            }
            return $dingzhi_id;
        };
        return false;
    }
}
