<?php
/**
 * Created by PhpStorm.
 * User: Medcon
 * Date: 2020/9/3
 * Time: 21:07
 */

namespace photolive\controllers;

use Yii;
use yii\web\Controller;
use common\models\UploadForm;
use yii\helpers\Json;
use yii\web\UploadedFile;
/**
 * API安全验证
 * @Author   NingWang
 * @DateTime 2017-12-15
 * @version  [version 1.0.0]
 */
class TokenController extends Controller
{

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
        $Json['message'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);
    }

    //删除文件  $path为绝对路径
    public function actionDelFile()
    {
        $file = \Yii::$app->request->post('fileSrc');
        if (file_exists($file)) {
            $url = iconv('utf-8', 'gbk', $file);
            if (PATH_SEPARATOR == ':') { //linux
                if (unlink($file)) {
                    return $this->convertJson('100000', '删除成功');
                }
            } else {  //Windows
                if (unlink($url)) {
                    return $this->convertJson('100000', '删除成功');
                };
            }
            return $this->convertJson('100000', '删除失败');
        } else {
            return $this->convertJson('100000', '您要删除的文件已不存在');
        }
    }

    /* 删除文件夹以及文件夹下所有文件 */
    public function actionDelDir()
    {
        $dir = \Yii::$app->request->post('dir');
        if ($this->delDir($dir)) {
            return $this->convertJson('100000', '数据清理完成');
        };
        return $this->convertJson('100000', '数据清理完成');
    }

    /* 删除目录 */
    public function delDir($dir)
    {
        //先删除目录下的文件：
        if (!is_dir($dir)) return false;
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->delDir($fullpath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return array
     * 图片上传
     */
    public function actionUploadImage()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $params = \Yii::$app->request->post();
            $dress = isset($params['dir']) ? $params['dir'] . '/' : 'common/';
            $rootDir = 'uploads/' . $dress;

            $model->file = UploadedFile::getInstanceByName('file');  //这个方式是js提交
            $image_name = $model->file->name;
            $image_size = $model->file->size;
            if ($model->file && $model->validate()) {
                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                $date = date('Ymd') . '_';
                $fileSrc = $rootDir . $date . rand(10000, 99999) . time() . '.' . $model->file->extension;
                $model->file->saveAs($fileSrc);
                $photoInfo = getimagesize($fileSrc);

                //压缩图片
                /* if($iscompress){
                     $source = $fileSrc;
                     $dst_img = $fileSrc; //可加存放路径
                     $percent = 1;  #原图压缩，不缩放
                     (new Imgcompress($source,$percent))->compressImg($dst_img);
                 }*/
                return $this->convertJson('100000', '上传成功', array('fileSrc' => $fileSrc, 'filesize' => $image_size, 'name' => $image_name, 'width' => $photoInfo[0], 'height' => $photoInfo[1]));
            }
            return $this->convertJson('100001', '上传失败');
        }
    }
    /**
     * 创建Token密钥
     * @param    Int     $uid [用户ID]
     * @return   Str          [生成的Token密钥]
     */
    public function actionCreateToken($uid)
    {
        #获取配置文件中Token验证参数
        $auth = Yii::$app->params['auth'];
        #获取当前时间[目的:设置时间超时机制]
        $nowTime = time();

        #两次md5加密保证密钥安全性
        $secret = md5(md5($auth['secret'].$nowTime));
        #设置加密数据[目的:拼接当前时间 & 传递参数]
        $data = $secret.'O_O'.$nowTime;

        #设置加密密码[目的:拼接用户ID,设置动态Key值]
        $secret = $auth['key'].$uid;

        #Yii加密算法生成Toekn(参数1:加密数据 参数2:自定义密码)
        $token = Yii::$app->getSecurity()->encryptByPassword($data,$secret);
        #由于生成的token乱码，我们可以base64加密,以便后续查看
        $token = base64_encode($token);
        return $token;
    }


    /**
     * 验证请求
     * @param    Int     $uid   [用户ID]
     * @param    Str     $token [Token密钥]
     * @return   Json           [验证结果]
     */
    public function actionCheckToken($uid,$token)
    {
        #获取配置文件中Token验证参数
        $auth = Yii::$app->params['auth'];
        #获取Token生成时的加密密码
        $secret = $auth['key'].$uid;
        #base64解码token
        $token = base64_decode($token);

        #Yii解密算法获取加密数据(参数1:Token 参数2:Token生成时设置的密码)
        #失败返回false,成功返回Token
        $data = Yii::$app->getSecurity()->decryptByPassword($token,$secret);
        if(!$data){
            $res = $this->error('401','Token验证失败');
        }else{
            $data = explode('O_O', $data);
            #检测Token数据完整性[包含加密密钥&时间]
            if(count($data)!=2){
                $res = $this->error('401','Token验证失败');
            }else{
                #检测时间超时机制
                if(time()-$data[1]>$auth['timeout']){
                    $res = $this->error('401','Token已过期');
                }else{
                    #检测加密密钥
                    $secret = md5(md5($auth['secret'].$data[1]));
                    if($secret == $data[0]){
                        $res = $this->success();
                    }else{
                        $res = $this->error('401','密钥出错');
                    }
                }
            }
        }
        return $res;
    }

    /**
     * 成功信息
     * @param Array $data 查询数据
     * @return Array 返回请求页面数据
     */
    public function success($data='')
    {
        return array(
            'code'  =>  '200',
            'message'   =>  'Token验证成功',
            'data'  =>  $data
        );
    }
    /**
     * 错误信息
     * @param Array $msg 提示消息
     * @return Array 返回请求页面数据
     */
    public function error($code,$msg='查询失败',$data='')
    {
        return array(
            'code'  =>  $code,
            'message'   =>  $msg,
            'data'  =>  $data
        );
    }

}
?>

