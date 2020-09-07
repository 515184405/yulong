<?php
namespace photolive\controllers;

use common\models\User;
use Yii;
use common\models\UploadForm;
use yii\helpers\Json;
use yii\web\imgcompress;
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
                        'actions' => ['login', 'error','captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['upload-widget','params','zixun','demo','sort','logout', 'index','info','type','change-pwd','delete','add-type','recommend','upload-image','upload','upload-file','issue','is-down'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className() ,
                'actions' => [
                    'logout' => ['get'],
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
                    'imageUrlPrefix' => Yii::$app->params['backend_url'], /* 图片访问路径前缀 */
                ]
            ]
        ];
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $user_id = Yii::$app->user->id;
        $userInfo = User::findOne($user_id);
        //向公共页面传递数据
        Yii::$app->view->params['userInfo'] = $userInfo;
    }

    public function getUserInfo(){
        return Yii::$app->user->id;
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

    public function getRandomString($len, $chars=null)
    {
        if (is_null($chars)){
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }

    /**
     * @param bool $iscompress 是否压缩
     * @return array
     */
    public function uploadImage($iscompress = true){
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

                //压缩图片
               /* if($iscompress){
                    $source = $fileSrc;
                    $dst_img = $fileSrc; //可加存放路径
                    $percent = 1;  #原图压缩，不缩放
                    (new Imgcompress($source,$percent))->compressImg($dst_img);
                }*/

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