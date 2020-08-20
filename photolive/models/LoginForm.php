<?php
namespace photolive\models;

use Yii;
use yii\base\Model;
use photolive\models\User;

/**
 * Signup form
 */
class LoginForm extends Model
{
    public $phone;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'min' => 11, 'max' => 11],

            [['password'], 'required'],
            [['password'], 'string', 'min' => 6],
        ];
    }

    /**
     * Login.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function loginup(){
        if(!$this->validate()){
            return false;
        }
        $user = User::findOne(['phone'=>$this->phone]);//通过用户输入的用户名重表中选出数据
        if($user !== null){
            if(Yii::$app->security->validatePassword($this->password,$user->password)){
                //密码校验，第一个参数为用户输入的密码，第二个为通过用户名选出来用户原本的hash加密的密码
                Yii::$app->user->login($user,3600*24*7);//rememberMe是“是否记住我”的选项值为bool型
                //这是User类中的方法，第一个参数必须是IdentityInterface的实例。第二个参数就是你的cookie存活时间
                return $user;
            }
            return false;
        }else{
            return false;
        }
    }


}
