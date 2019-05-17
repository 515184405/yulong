<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use common\models\LoginForm;
use yii\helpers\Json;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
//                'class' => 'common\components\Mycaptcha',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0xffffff,  //背景颜色
                'maxLength' => 4,       //最大显示个数
                'minLength' => 4,       //最少显示个数
                'padding' => 5,         //间距
                'height'=>36,           //高度
                'width' => 100,         //宽度
                'foreColor'=>0x000000,  //字体颜色
                'offset'=>4,            //设置字符偏移量 有效果
                //'controller'=>'login', //拥有这个动作的controller
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
//        var_dump(Yii::$app->security->generatePasswordHash('000000'));die;
        $model = new LoginForm();
        if(Yii::$app->request->isPost){
//            var_dump($_POST['verifyCode']);
          if($this->createAction('captcha')->validate($_POST['verifyCode'],false)) {
              if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
                  //return $this->goBack();
                  $user = new User();

                  return Json::encode(array('code' => '100000', 'message' => '登陆成功'));
              } else {
                  return Json::encode(array('code' => '100001', 'message' => '用户名或密码错误'));
              }
          }else{
              return Json::encode(array('code' => '100001', 'message' => '验证码错误'));
          }
        }

        return $this->renderPartial('login');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
