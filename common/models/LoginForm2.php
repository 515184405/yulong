<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm2 extends Model
{
    public $username;
    public $openid;
    public $accessToken;
    public $rememberMe = true;
//    public $verifyCode; //验证码变量，存储验证码变量的值

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'openid','accessToken'], 'required'],
        ];
    }

    public function  attributeLabels()
    {
        return [
            'username'=>'用户名',
            'openid'=>'openid',
            'accessToken'=>'accessToken',
            'remember'=>'记住密码',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if(!$user){
                $this->addError($attribute.'_not', '用户名不存在');
            }else if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '密码不正确');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            //30天后自动过期
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Member::findByUsername($this->username);
        }
        return $this->_user;
    }
}
