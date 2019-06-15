<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property int $sex 0:男 1：女
 * @property string $province 省份
 * @property string $city 城市
 * @property string $avatar 头像
 * @property string $accessToken token
 * @property string $openid openid
 * @property int $type 类型(1:QQ,2:微博）
 * @property int $created_time 注册时间
 * @property int $updated_time 修改时间
 * @property int $login_time 上一次登录时间
 * @property int $update_password 修改密码次数
 * @property int $status 0为有效用户 1为无效用户
 */
class Member extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'sex', 'created_time', 'updated_time', 'login_time'], 'required'],
            [['sex','status', 'type', 'created_time', 'updated_time', 'login_time', 'update_password'], 'integer'],
            [['username', 'password', 'openid'], 'string', 'max' => 70],
            [['province', 'city'], 'string', 'max' => 25],
            [['avatar', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'sex' => 'Sex',
            'province' => 'Province',
            'city' => 'City',
            'avatar' => 'Avatar',
            'accessToken' => 'Access Token',
            'openid' => 'Openid',
            'type' => 'Type',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'login_time' => 'Login Time',
            'update_password' => 'Update Password',
            'status' => 'Status'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;*/
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = Member::find()
            ->where(['username' => $username])
            ->asArray()
            ->one();

        if($user){
            return new static($user);
        }

        return null;
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;*/
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
