<?php
namespace frontend\controllers;

use common\models\CaseType;
use common\models\Banner;
use common\models\Cases;
use common\models\Member;
use common\models\News;
use common\models\Widget;
use common\models\WidgetType;
use common\models\Zixun;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\LoginForm2;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends CommonController
{


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = [];
        /*轮播图数据*/
        $data['banner'] = Banner::find()->orderBy(['sort'=>SORT_ASC])->asArray()->all();
        //案例列表数据
        $data['case'] = Cases::find()->orderBy(['id'=>SORT_DESC])->limit(3)->asArray()->all();
        //案例类型数据
        $data['case_type'] = CaseType::find()->limit(8)->asArray()->all();
        //组件列表数据
        $data['widget'] = Widget::find()->where(['status'=>1])->orderBy(['id'=>SORT_DESC])->limit(3)->asArray()->all();
        //组件类型数据
        $data['widget_type'] = WidgetType::find()->limit(8)->asArray()->all();
        //新闻列表数据
        $data['news'] = News::find()->where(['issue'=>2])->orderBy(['id'=>SORT_DESC])->limit(5)->asArray()->all();
        return $this->render('index',compact('data'));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
//       if (!Yii::$app->user->isGuest) {
//            return $this->redirect('/user');
//        }
//        $params = [
//            'username' => '1111',
//            'sex' => 0,
//            'openid' => '222222222',
//            'accessToken' => '111111111',
//            'province' => '辽宁',
//            'city' => '葫芦岛',
//            'avatar' => '1.png',
//            'type' => 1,
//            'created_time' => time(),
//            'updated_time' => time(),
//            'login_time' => time(),
//            'update_password' => 0
//        ];
//        $member = Member::find()->where(['openid'=>$params['openid'],'accessToken'=>$params['accessToken']])->one();
//        $model = new LoginForm2();
//        $model->setAttributes($params);
//        if($member){
//            if($model->login()){
//                echo "<script type='text/javascript'>window.opener.location.href = window.opener.location.href;window.close();</script>";
//            }
//        }else{
//            $member = new Member();
//            $member->setAttributes($params);
//            //打印出个人信息
//            if ($member->save() && $model->login()) {
//                echo "<script type='text/javascript'>window.opener.location.href = window.opener.location.href;window.close();</script>";
//            } else {
                return $this->renderPartial('login');
//            }
//        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionStatus()
    {
        $error_text = '此账户涉嫌多次违规已被封号处理;如有疑问请联系网站管理员解答电话：15321353313 QQ:515184405<a href="/">返回首页</a>';
        return $this->renderPartial('status',compact('error_text'));
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    //建站咨询
    public function actionWebsite()
    {
        if(Yii::$app->request->isPost){
            $params = Yii::$app->request->post();
            if(Zixun::insertUpdate($params)){
                $this->sendsMail('建站咨询','<div style="font-family: \'Microsoft YaHei\';">
                    咨询人：<b>'.$params["name"].'</b></br>
                    咨询人电话：<b><a href="tel:'.$params["tel"].'">'.$params["tel"].'</a></b></br>
                    咨询人邮件：<b>'.$params["email"].'</b></br>
                    咨询内容：<b>'.$params["content"].'</b></br>
                </div>');
                return Json::encode(array('code'=>'100000','message'=>'咨询以发送，我们会尽快与您联系！'));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            };
        }

        return $this->renderPartial('website');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /*QQ登录*/
    public function actionQqlogin(){
        require_once("../../vendor/qqlogin/qqConnectAPI.php");
        $qc = new \QC();
        $qc->qq_login();
    }

    //回调函数
    public function actionQqcallback(){
        require_once("../../vendor/qqlogin/qqConnectAPI.php");
        $auth = new \OAuth();
        $accessToken = $auth->qq_callback();
        $openid = $auth->get_openid();
        $qc = new \QC($accessToken, $openid);
        $userinfo = $qc->get_user_info();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //打印出个人信息
        $params = [
           'username' => $userinfo['nickname'],
            'sex' => $userinfo['gender'] == "男" ? 0 : 1,
            'province' => $userinfo['province'],
            'city' => $userinfo['city'],
            'avatar' => $userinfo['figureurl_2'],
            'accessToken' => $accessToken,
            'openid' => $openid,
            'type' => 1,
            'created_time' => time(),
            'updated_time' => time(),
            'login_time' => time(),
            'update_password' => 0
        ];
        $member = Member::find()->where(['openid'=>$params['openid'],'accessToken'=>$params['accessToken']])->one();
        $model = new LoginForm2();
        $model->setAttributes($params);
        if($member){
            if($model->login()){
                echo "<script type='text/javascript'>window.opener.location.href = window.opener.location.href;window.close();</script>";
            }
        }else{
            $member = new Member();
            $member->setAttributes($params);
            //打印出个人信息
            if ($member->save() && $model->login()) {
                echo "<script type='text/javascript'>window.opener.location.href = window.opener.location.href;window.close();</script>";
            } else {
                return $this->renderPartial('login');
            }
        }
    }

    //图片上传
    public function actionUploadImage(){
        $uploadImage = $this->uploadImage();
        if(isset($uploadImage)){
            if($uploadImage['status']) {
                return Json::encode(array('code'=>'100000','message'=>'添加成功！','data'=>array(
                    'fileName' => $uploadImage['fileName'],
                    'fileSrc' => '/'.$uploadImage['fileSrc']
                )));
            }else{
                return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
            }
        }
    }
}
