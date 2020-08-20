<?php

namespace photolive\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $pid 父id
 * @property string $username 用户名
 * @property int $sex
 * @property string $password 密码
 * @property int $type 类型(1:超级管理员,2:管理员
 * @property int $created_time 注册时间
 * @property int $updated_time 修改时间
 * @property int $status 封禁状态，0禁止1正常
 * @property string $login_ip 登录ip
 * @property int $login_time 上一次登录时间
 * @property int $login_count 登陆次数
 * @property int $update_password 修改密码次数
 * @property int $province_id 省份id
 * @property int $city_id 城市id
 * @property int $area_id 区县id
 * @property string $phone
 */
class User extends ActiveRecord implements IdentityInterface
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
            [['pid', 'type', 'created_time', 'updated_time','login_time', 'status', 'login_time', 'login_count', 'update_password', 'province_id', 'city_id', 'area_id'], 'integer'],
            [['username', 'sex', 'password', 'login_ip', 'phone'], 'required'],
            [['username', 'password','auth_key'], 'string', 'max' => 70],
            [['login_ip'], 'string', 'max' => 20],
            [['phone','sex'], 'string', 'max' => 12],
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
            'sex' => 'Sex',
            'password' => 'Password',
            'type' => 'Type',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'status' => 'Status',
            'login_ip' => 'Login Ip',
            'login_time' => 'Login Time',
            'login_count' => 'Login Count',
            'update_password' => 'Update Password',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'phone' => 'Phone',
            'auth_key' => 'Auth key',
        ];
    }
    /*查数据*/
    public static function search($params){
        $query = static::find();
        //按title查找
        if(isset($params['username'])){
            $query->andFilterWhere(['and',['like','username',$params['username']],['type'=>2]]);
        }
        $query->andFilterWhere(['type'=>2]);
        $page = isset($params['page']) ? $params['page'] : '';
        $limit = isset($params['limit']) ? $params['limit'] : '';
        $count = 0;
        if($page && $limit){
            $offset = ($page - 1) * $limit;
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $list = $query->orderBy(['id' => SORT_DESC])->asArray()->all();
        return compact('count', 'list');
    }

    //添加与修改
    public static function insetUpdate($params,$user_id = null){
        $user = new User();
        if($user_id){
            $user = User::findOne($user_id);
            $params['login_count'] = intval($user->login_count) + 1;
        }else{
            $params['created_time'] = time();
            $params['login_time'] = time();
            $params['login_ip'] = $_SERVER["REMOTE_ADDR"];
            $params['type'] = 2;
        }
        $params['updated_time'] = time();
        $params['password'] = \Yii::$app->security->generatePasswordHash($params['password']);
        $user->setAttributes($params);
        if($user->save()){
            var_dump($user->getErrors());die;
            return true;
        }else{
            var_dump($user->getErrors());die;
            return false;
        }
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
     * @param $password
     * 存储并加密密码
     */
    public  function setPassword($password)
    {
        $this->password=\Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
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
