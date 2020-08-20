<?php
namespace photolive\models;

use Yii;
use yii\base\Model;
use photolive\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $sex;
    public $phone;
    public $password;
    public $repassword;
    public $province_id;
    public $city_id;
    public $area_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255, 'message' => '姓名不能为空.'],

            ['sex', 'required'],
            ['province_id', 'required'],
            ['city_id', 'required'],
            ['area_id', 'required'],

            ['phone','trim'],
            ['phone', 'required'],
            ['phone', 'unique', 'targetClass' => '\photolive\models\User', 'message' => '手机号码已存在.'],
            ['phone', 'string', 'min' => 11, 'max' => 11],

            [['password','repassword'], 'required'],
            [['password','repassword'], 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->sex = $this->sex;
        $user->phone = $this->phone;
        $user->province_id = $this->province_id;
        $user->city_id = $this->city_id;
        $user->area_id = $this->area_id;
        $user->login_ip =
        $user->created_time = time();
        $user->login_time = time();
        $user->login_ip = $_SERVER["REMOTE_ADDR"];
        $user->generateAuthKey();
        $user->save();
        return $user;
//        $user->generateEmailVerificationToken();
//        $id = $user->save();
//        if($id){
//            return $id;
//        }else{
//            var_dump($user->getErrors());die;
//        }
    }
}
