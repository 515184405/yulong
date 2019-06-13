<?php
namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use common\models\UploadForm;
use yii\web\UploadedFile;

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
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config'=>[
                    //上传图片配置
                    //'imageUrlPrefix' => Yii::$app->params['site_url'], /* 图片访问路径前缀 */
                ]
            ]
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

    public function sendsMail($title,$htmlBody){
        //邮件发送
        $mail = Yii::$app->mailer->compose();
        $mail->setTo('515184405@qq.com');
        $mail->setSubject($title);
        $mail->setHtmlBody($htmlBody);
        if($mail->send()){
            return true;
        }else{
            return false;
        };
        //邮件发送
    }

    //图片上传
    public function uploadImage(){
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $date = date('Ymd').'/';
            $dress = isset($_POST['caseDir']) ? $_POST['caseDir'] : 'template/';
            $rootDir = 'uploads/'.$dress.$date;
            $fileName = isset($_POST['fileName']) ? $_POST['fileName'] : '';
            $model->file = UploadedFile::getInstanceByName('file');  //这个方式是js提交
            if ($model->file && $model->validate()) {
                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                $fileSrc=$rootDir . rand(10000, 99999) .time() . '.' . $model->file->extension;
                $model->file->saveAs($fileSrc);
                return array(
                    'fileName' => $fileName,
                    'fileSrc' => $fileSrc,
                    'status' => true,
                );
            }
            return array(
                'status' => false,
            );
        }
    }
}