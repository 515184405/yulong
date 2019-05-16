<?php
namespace backend\controllers;

use Yii;
use common\models\UploadForm;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * {@inheritdoc}
 */
class CommonController extends \yii\web\Controller{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className() ,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config'=>[
                    //上传图片配置
                    //'imageUrlPrefix' => Yii::$app->params['site_url'], /* 图片访问路径前缀 */
                ]
            ]
        ];
    }

    /**转Json格式
     * @param $code
     * @param $message
     * @param $data
     * @param $count
     * @return string
     */
    public function convertJson($code, $message, $data = '', $count = null)
    {

        $Json['code'] = $code;
        $Json['msg'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);

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