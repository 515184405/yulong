<?php

namespace photolive\models;

use Yii;

/**
 * This is the model class for table "photo_list".
 *
 * @property int $id 相册id
 * @property string $name 相册名称
 * @property string $desc 相册描述
 * @property int $look 点击量
 * @property string $cover_image 封面图
 * @property int $type_id type_id 相册类型id
 * @property string $pass 相册密码
 * @property int $province_id 省份id
 * @property int $city_id 城市id
 * @property int $area_id 区县id
 * @property string $address 详细地址
 * @property int $u_id 用户id
 * @property int $author_id 作者id
 * @property string $createtime 创建时间
 * @property string $starttime 开始时间
 * @property string $endtime 结束时间
 * @property string $tel 手机号
 * @property int $status 0未发布，1已发布
 * @property int $photo_number 照片数量
 */
class PhotoList extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['look', 'type_id', 'province_id', 'city_id', 'area_id', 'u_id', 'author_id', 'status', 'photo_number'], 'integer'],
            [['type_id', 'createtime'], 'required'],
            [['createtime', 'starttime', 'endtime'], 'safe'],
            [['name', 'desc', 'cover_image', 'address'], 'string', 'max' => 255],
            [['pass'], 'string', 'max' => 50],
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
            'desc' => 'Desc',
            'look' => 'Look',
            'cover_image' => 'Cover Image',
            'type_id' => 'Type ID',
            'pass' => 'Pass',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'address' => 'Address',
            'u_id' => 'U ID',
            'author_id' => 'Author ID',
            'createtime' => 'Createtime',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'status' => 'Status',
            'photo_number' => 'Photo Number',
        ];
    }

    /*关联photo_cover*/
    public function getPhotoCover(){
        return $this->hasOne(PhotoCoverSettings::className(),['project_id' => 'id']);
    }

    /*关联photo_group*/
    public function getPhotoGroup(){
        return $this->hasMany(PhotoGroupSettings::className(),['project_id' => 'id']);
    }

    /*关联photo_top_share*/
    public function getPhotoTopShare(){
        return $this->hasOne(PhotoTopShareSettings::className(),['project_id' => 'id']);
    }

    /*关联photo_Water*/
    public function getPhotoWater(){
        return $this->hasOne(PhotoWaterSettings::className(),['project_id' => 'id']);
    }

    /*关联photo_wx_share*/
    public function getPhotoWxShare(){
        return $this->hasOne(PhotoWxShareSettings::className(),['project_id' => 'id']);
    }

    /*关联类型表*/
    public function getPhotoType(){
        return $this->hasOne(PhotoType::className(),['id' => 'type_id']);
    }

    /*关联企业表*/
    public function getPyInfo(){
        return $this->hasOne(PyList::className(),['u_id' => 'u_id']);
    }

    /*关联皮肤表*/
    public function getPhotoSkin(){
        return $this->hasOne(PhotoSkin::className(),['project_id' => 'id']);
    }

    /*关联显示格式*/
    public function getPhotoColType(){
        return $this->hasOne(PhotoColType::className(),['project_id' => 'id']);
    }


}
