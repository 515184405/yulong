<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "widget".
 *
 * @property int $id
 * @property int $u_id 用户id
 * @property string $title
 * @property string $desc
 * @property string $banner_url
 * @property string $type 组件类型
 * @property string $source 作品来源
 * @property string $rule 作品使用描述
 * @property string $look 点击率
 * @property string $collect 喜欢
 * @property string $download 下载地址
 * @property string $website 官网地址
 * @property string $down_count 下载次数
 * @property string $create_time
 * @property string $recommend 0不推荐 1推荐
 * @property int $is_down 是否下载 0 可下载 1不可下载
 * @property int $status 0 审核中 1 已通过 2 未通过
 * @property int $down_money 下载币数
 * @property string $fail_msg 失败信息
 * @property string $enter_file 入口文件
 * @property string $upload_enter_file 更新入口
 * @property string $upload_download 更新后的下载地址
 * @property string $upload_txt 更新说明
 */
class Widget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'widget';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'title', 'desc'], 'required'],
            [['u_id', 'look', 'collect', 'down_count', 'create_time', 'recommend', 'is_down', 'status', 'down_money'], 'integer'],
            [['rule'], 'string'],
            [['title', 'desc', 'banner_url', 'type', 'source', 'download', 'website', 'enter_file', 'upload_enter_file', 'upload_download'], 'string', 'max' => 255],
            [['fail_msg'], 'string', 'max' => 100],
            [['upload_txt'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'banner_url' => 'Banner Url',
            'type' => 'Type',
            'source' => 'Source',
            'rule' => 'Rule',
            'look' => 'Look',
            'collect' => 'Collect',
            'download' => 'Download',
            'website' => 'Website',
            'down_count' => 'Down Count',
            'create_time' => 'Create Time',
            'recommend' => 'Recommend',
            'is_down' => 'Is Down',
            'status' => 'Status',
            'down_money' => 'Down Money',
            'fail_msg' => 'Fail Msg',
            'enter_file' => 'Enter File',
            'upload_enter_file' => 'Upload Enter File',
            'upload_download' => 'Upload Download',
            'upload_txt' => 'Upload Txt',
        ];
    }
    //查询推荐组件
    public static function recommend(){
        return Widget::find()->where(['and',['recommend'=>1],['status'=>1]])->orderBy('id',SORT_DESC)->limit(3)->asArray()->all();
    }

    /*关联用户表*/
    public function getUserInfo(){
        return $this->hasOne(Member::className(),['id'=>'u_id'])->select(['username','province','city','avatar']);
    }

    /*待审核数据*/
    public static function widgetStatus(){
        return static::find()->where(['status'=>0])->asArray()->count();
    }

    /*查数据*/
    public static function search($params){
        $query = static::find();
        $sort = isset($params['sort']) ? $params['sort'] : 1;
        $status = isset($params['status']) ? $params['status'] : '';
        //按title status查找
        if(isset($params['title'])){
            $query->andFilterWhere(['or',['like','Widget.title',$params['title']],['=','widget.status',$status]]);
        }
        $page = isset($params['page']) ? $params['page'] : '';
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        if($sort == 1){
            $list = $query->orderBy(['create_time' => SORT_DESC])->asArray()->all();
        }else{
            $list = $query->orderBy(['create_time' => SORT_ASC])->asArray()->all();
        }
        return compact('count', 'list');
    }

    public static function insertUpdate($params,$widget_id = null){
        $model = new static();
        $params['create_time'] = time();
        if($widget_id){
            $model = $model::findOne($widget_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$widget_id) {
                return $model->attributes['id'];
            }
            return $widget_id;
        };
        return false;
    }
}
