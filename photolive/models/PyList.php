<?php

namespace photolive\models;

use photolive\models\CommonModel;
use Yii;

/**
 * This is the model class for table "py_list".
 *
 * @property int $id
 * @property int $u_id 用户id
 * @property string $logo 企业logo
 * @property string $name 企业名称
 * @property string $phone 企业手机号
 * @property string $website 企业网站
 * @property string $erweima 企业二维码
 * @property string $desc 描述
 * @property string $createtime 创建时间
 * @property int $look
 * @property string $banner_url
 * @property string $address
 * @property string $title
 */
class PyList extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'py_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['u_id', 'createtime'], 'required'],
            [['u_id', 'look'], 'integer'],
            [['createtime'], 'safe'],
            [['logo', 'website','title', 'erweima', 'desc', 'banner_url'], 'string', 'max' => 255],
            [['name', 'address'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
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
            'logo' => 'Logo',
            'name' => 'Name',
            'phone' => 'Phone',
            'website' => 'Website',
            'erweima' => 'Erweima',
            'desc' => 'Desc',
            'createtime' => 'Createtime',
            'look' => 'Look',
            'banner_url' => 'Banner Url',
            'address' => 'Address',
            'title' => 'Title',
        ];
    }
}
