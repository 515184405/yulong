<?php
namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class CommonController extends \yii\web\Controller{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        //查询推荐组件
        $recommend_widget = \common\models\Widget::recommend();
        //查询推荐新闻
        $recommend_news = \common\models\News::recommend();
        //查询推荐案例
        $recommend_case = \common\models\Cases::recommend();
        $recommend = array(
            'recommend_news' => $recommend_news,
            'recommend_case' => $recommend_case,
            'recommend_widget' => $recommend_widget
        );

        \Yii::$app->view->params['recommend'] = $recommend;
    }
}