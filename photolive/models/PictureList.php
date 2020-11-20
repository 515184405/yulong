<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "picture_list".
 *
 * @property int $id
 * @property string $name 照片名称
 * @property string $src 原图地址
 * @property string $waterSrc 水印图片地址
 * @property int $status 状态 0私有 1公开
 * @property int $groupId 分组id
 * @property string $createtime 创建时间
 * @property string $size 图片尺寸 宽X高  例1920x1080
 * @property string $filesize 文件大小
 * @property string $water_filesize 水印文件大小
 * @property int $like 点赞数
 * @property int $collect 收藏数量
 * @property int $project_id 相册id
 */
class PictureList extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'src', 'createtime', 'project_id'], 'required'],
            [['status', 'groupId', 'like', 'collect', 'project_id'], 'integer'],
            [['createtime'], 'safe'],
            [['name', 'src'], 'string', 'max' => 255],
            [['waterSrc'], 'string', 'max' => 1500],
            [['size'], 'string', 'max' => 50],
            [['filesize','water_filesize'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'src' => 'Src',
            'waterSrc' => 'Water Src',
            'status' => 'Status',
            'groupId' => 'Group ID',
            'createtime' => 'Createtime',
            'size' => 'Size',
            'filesize' => 'Filesize',
            'like' => 'Like',
            'collect' => 'Collect',
            'project_id' => 'Project ID',
            'water_filesize' => 'Water Filesize'
        ];
    }
    /**
     * 查找列表方法
     * @param array $arr
     * @return string
     */
    public static function getPictureList($arr = []){
        $result = static::find()->where($arr)->orderBy(['id'=>SORT_DESC])->asArray()->all();
        foreach ($result as $index => $item) {
            $item['minsrc'] = $item['src'].'!msrc'; // 小图
            #item['maxsrc'] = $item['src'].'!msrc'; // 大图
        }
        return self::convertJson('100000','查询成功',$result);
    }

    /**
     * 新增与更新方法
     * @param $params
     * @return string
     */
    public static function pictureInsertUpdate($params){
        $model = new static();
        if($params['id']) {
            $message = '修改';
            $model = static::findOne($params['id']);
        }else{
            $message = '添加';
            $params['createtime'] = date('Y-m-d H:i:s',time());
        }
        $model->setAttributes($params);
        if($model->save()){
            return self::convertJson('100000',$message.'成功',$model->attributes);
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001',$message.'失败');
        }
    }
}
