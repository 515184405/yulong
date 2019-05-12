<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $pid 父id
 * @property string $username 用户名
 * @property string $password 密码
 * @property int $type 类型(1:总店,2:门店,3:管理员)
 * @property int $created_time 注册时间
 * @property int $updated_time 修改时间
 * @property int $status 封禁状态，0禁止1正常
 * @property string $login_ip 登录ip
 * @property int $login_time 上一次登录时间
 * @property int $login_count 登陆次数
 * @property int $update_password 修改密码次数
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'type', 'created_time', 'updated_time', 'status', 'login_time', 'login_count', 'update_password'], 'integer'],
            [['username', 'password', 'created_time', 'updated_time', 'login_ip', 'login_time'], 'required'],
            [['username', 'password'], 'string', 'max' => 70],
            [['login_ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'username' => 'Username',
            'password' => 'Password',
            'type' => 'Type',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'status' => 'Status',
            'login_ip' => 'Login Ip',
            'login_time' => 'Login Time',
            'login_count' => 'Login Count',
            'update_password' => 'Update Password',
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
        $user = User::find()
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
        return $this->password === $password;
    }
}
