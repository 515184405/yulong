<?php
namespace frontend\controllers;

use common\models\Widget;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class WidgetController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionWidget()
    {
        $id = Yii::$app->request->get('id');
        $create_time = Yii::$app->request->get('create_time');
        $model = Widget::findOne($id);
        if(!isset($id) || !isset($create_time) || !$model || ($model->create_time != $create_time)){
            return '没有此项目';
        }
        $url = '/widget/'.$id.'/';
        return $this->renderPartial($id.'\index',compact('url'));
    }
}
