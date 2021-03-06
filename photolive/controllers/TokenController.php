<?php
/**
 * Created by PhpStorm.
 * User: Medcon
 * Date: 2020/9/3
 * Time: 21:07
 */

namespace photolive\controllers;

use photolive\models\PhotoWaterSettings;
use Yii;
use yii\web\Controller;
use common\models\UploadForm;
use yii\helpers\Json;
use yii\web\UploadedFile;

//跨域访问的时候才会存在此字段
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
$allow_origin = array(
    'http://sheyingpai.m.yu313.cn',
    'http://sheyingpai.yu313.cn',
    'https://sheyingpai.m.yu313.cn',
    'https://sheyingpai.yu313.cn',
);
if(in_array($origin, $allow_origin)) {
    header('Access-Control-Allow-Origin:'.$origin);
    header('Access-Control-Allow-Methods:GET,HEAD,PUT,POST,DELETE,PATCH,OPTIONS');
    header('Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept,key,token');
}
/**
 * API安全验证
 * @Author   NingWang
 * @DateTime 2017-12-15
 * @version  [version 1.0.0]
 */
class TokenController extends Controller
{

    public function beforeAction($action)
    {
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
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
        $Json['message'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);
    }

    public function actionAliyunAuth(){
        $data = Yii::$app->params['oss'];
        return $this->convertJson('100000', '获取成功',$data);
    }

    /**
     * 删除oss上图片
     * $file 为一个数组  $objects = ['文件名1','文件名2'];
     */
    public function actionDelFile($file = null)
    {
        $file = $file ? $file : \Yii::$app->request->post('fileSrc');
        if ($file) {
            if (!is_array($file)) {
                $file = [$file];
            }
            if (Yii::$app->Aliyunoss->delete($file)) {
                return $this->convertJson('100000', '删除成功');
            };
            return $this->convertJson('100001', '删除失败');
        } else {
            return $this->convertJson('100001', '您要删除的文件已不存在');
        }
    }

    /* 删除文件夹以及文件夹下所有文件 */
    /*  public function actionDelDir()
      {
          $dir = \Yii::$app->request->post('dir');
          if ($this->delDir($dir)) {
              return $this->convertJson('100000', '数据清理完成');
          };
          return $this->convertJson('100000', '数据清理完成');
      }*/

    /* 删除目录 */
    /*public function delDir($dir)
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
    }*/


    /**
     * @return 本地删除文件
     */
    public function deleteFile($file)
    {
        $file = $file ? $file : \Yii::$app->request->post('fileSrc');
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

    public function actionResizeImage()
    {
        Yii::$app->Aliyunoss->test();

    }

    /**
     * @return array
     * 图片上传
     */
    public function actionUploadImage()
    {
        $model = new UploadForm();
        if (\Yii::$app->request->isPost) {
            ini_set("memory_limit",'-1');
            $params = \Yii::$app->request->post();
            // oss上新目录
            $dress = isset($params['dir']) ? $params['dir'] . '/' : 'common/';
            // 本地暂存目录
            $rootDir = 'uploads/oss/';

            $model->file = UploadedFile::getInstanceByName('file');  //这个方式是js提交
            // 文件名
            $image_name = $model->file->name;
            // 文件大小
            $image_size = $model->file->size;
            $image_size = round($image_size / 1048576 * 100) / 100;
            if ($model->file && $model->validate()) {
                // 如果不存在则创建目录
                is_dir($rootDir) OR mkdir($rootDir, 0777, true);
                // 获取年月日
                $date = date('Ymd') . '_';
                // 更改后的名
                $fileName = $date . rand(10000, 99999) . time() . '.' . $model->file->extension;
                // 缓存文件相对路径
                $fileSrc = $rootDir . $fileName;
                // 保存文件
                if (!$model->file->saveAs($fileSrc)) {
                    return $this->convertJson('100001', '上传失败');
                };
                $photoInfo = getimagesize($fileSrc);
                $width = $photoInfo[0];
                $height = $photoInfo[1];
//                if($photoInfo){
//                    $width = $photoInfo[0] > 1920 ? 1920 : $photoInfo[0];
//                    $height = $width / $photoInfo[0] * $photoInfo[1];
//                    // 上传成功之后修改宽高
//                    $image = Yii::$app->Resizeimage->set_image($fileName, $fileSrc, '2500', '10000');
//                    header('Content-Type:image/jpeg');
//
//                    switch ($photoInfo['mime'] && $photoInfo[0] > 2500) {
//                        case 'image/jpeg':
//                            imagejpeg($image, $fileSrc);
//                            imagedestroy($image);
//                            break;
//                        case 'image/png':
//                            imagepng($image, $fileSrc);
//                            imagedestroy($image);
//                            break;
//                        case 'image/gif':
//                            // 上传成功之后修改宽高
//                            imagegif($image, $fileSrc);
//                            imagedestroy($image);
//                            break;
//                    }
//                }
                // 获取文件绝对路径
                $local_abs_src_tmp = dirname(dirname(__FILE__)) . '/web/uploads/oss/' . $fileName;
                $local_abs_src = str_replace("\\", "/", $local_abs_src_tmp);//绝对路径，上传第二个参数

                // 上传到oss上的文件路径
                $oss_abs_src = $dress . $fileName;
                // 上传到oss
                if (Yii::$app->Aliyunoss->upload($oss_abs_src, $local_abs_src)) {
                    // 删除本地缓存文件
                    $this->deleteFile($fileSrc);

                    //压缩图片
                    /* if($iscompress){
                         $source = $fileSrc;
                         $dst_img = $fileSrc; //可加存放路径
                         $percent = 1;  #原图压缩，不缩放
                         (new Imgcompress($source,$percent))->compressImg($dst_img);
                     }*/

                    // 上传成功
                    return $this->convertJson('100000', '上传成功', array('fileSrc' => $oss_abs_src, 'filesize' => $image_size, 'name' => $image_name, 'width' => $width, 'height' => $height));
                };
            }
            return $this->convertJson('100001', '上传失败');
        }
    }

    /**
     * oss上传
     */
    public function actionUploadOss(){
        $params = Yii::$app->request->post();
        $image = explode('.',$params['imgsrc']);
        $src_perfix = $params['perfix'];
        $dir  = $params['dir'];
        $nameType = end($image);

        // 获取年月日
        $date = date('Ymd') . '_';
        $fileName = $date . rand(10000, 99999) . time() . '.' . $nameType;
        $oss_abs_src = $dir.'/'.$fileName;
        var_dump($params['imgsrc'], $oss_abs_src, $src_perfix);die;
        $res = Yii::$app->Aliyunoss->water($params['imgsrc'], $oss_abs_src, $src_perfix);
        return $this->convertJson('100001', '上传失败',$res);
    }

    /**
     * base64图片上传
     */
    public function actionBase64Image(){
        ini_set("memory_limit",'-1');
        $params = \Yii::$app->request->post();
        $base64_img = trim($params['base64_img']);
        $image_name = $params['name'];
        // oss上新目录
        $dress = isset($params['dir']) ? $params['dir'] . '/' : 'common/';
        // 本地暂存目录
        $rootDir = 'uploads/oss/';
        if(!file_exists($rootDir)){
            mkdir($rootDir,0777);
        }

        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $date = date('Ymd') . '_';
                // 更改后的名
                $fileName = $date . rand(10000, 99999) . time() . '.' . $type;
                // 缓存文件相对路径
                $fileSrc = $rootDir . $fileName;
                if(file_put_contents($fileSrc, base64_decode(str_replace($result[1], '', $base64_img)))){

                    $image_size = round(ceil(filesize($fileSrc) / 1000) / 1024,3);
                    $width = 0;
                    $height = 0;
                    $photoInfo = getimagesize($fileSrc);
                    if($photoInfo){
                        $width = $photoInfo[0] > 1920 ? 1920 : $photoInfo[0];
                        $height = $width / $photoInfo[0] * $photoInfo[1];
                        // 上传成功之后修改宽高
                        $image = Yii::$app->Resizeimage->set_image($fileName, $fileSrc, '2500', '10000');
                        header('Content-Type:image/jpeg');

                        switch ($photoInfo['mime'] && $photoInfo[0] > 2500) {
                            case 'image/jpeg':
                                imagejpeg($image, $fileSrc);
                                imagedestroy($image);
                                break;
                            case 'image/png':
                                imagepng($image, $fileSrc);
                                imagedestroy($image);
                                break;
                            case 'image/gif':
                                // 上传成功之后修改宽高
                                imagegif($image, $fileSrc);
                                imagedestroy($image);
                                break;
                        }
                    }
                    // 获取文件绝对路径
                    $local_abs_src_tmp = dirname(dirname(__FILE__)) . '/web/uploads/oss/' . $fileName;
                    $local_abs_src = str_replace("\\", "/", $local_abs_src_tmp);//绝对路径，上传第二个参数

                    // 上传到oss上的文件路径
                    $oss_abs_src = $dress . $fileName;
                    // 上传到oss
                    if (Yii::$app->Aliyunoss->upload($oss_abs_src, $local_abs_src)) {
                        // 删除本地缓存文件
                        $this->deleteFile($fileSrc);

                        // 上传成功
                        return $this->convertJson('100000', '上传成功', array('fileSrc' => $oss_abs_src, 'filesize' => $image_size, 'name' => $image_name, 'width' => $width, 'height' => $height));
                    };

                }else{
                    return $this->convertJson('100001', '上传失败');
                }
            }else{
                //文件类型错误
                return $this->convertJson('100001', '图片上传类型错误');
            }

        }else{
            //文件错误
            return $this->convertJson('100001', '文件错误');
        }
    }

    /**
     * 设置token
     */
    public static function setTokenRadis($token,$userinfo){
        \Yii::$app->redis->set($token,Json::encode($userinfo));
        \Yii::$app->redis->expire($token,2*60*60); // 设置过期时间 俩小时
        return $token;
    }

    /**
     * 创建Token密钥
     * @param    Int $uid [用户ID]
     * @return   Str          [生成的Token密钥]
     */
    public function actionCreateToken($uid)
    {
        #获取配置文件中Token验证参数
        $auth = Yii::$app->params['auth'];
        #获取当前时间[目的:设置时间超时机制]
        $nowTime = time();

        #两次md5加密保证密钥安全性
        $secret = md5(md5($auth['secret'] . $nowTime));
        #设置加密数据[目的:拼接当前时间 & 传递参数]
        $data = $secret . 'O_O' . $nowTime;

        #设置加密密码[目的:拼接用户ID,设置动态Key值]
        $secret = $auth['key'] . $uid;

        #Yii加密算法生成Toekn(参数1:加密数据 参数2:自定义密码)
        $token = Yii::$app->getSecurity()->encryptByPassword($data, $secret);
        #由于生成的token乱码，我们可以base64加密,以便后续查看
        $token = base64_encode($token);
        return $token;
    }


    /**
     * 验证请求
     * @param    Int $uid [用户ID]
     * @param    Str $token [Token密钥]
     * @return   Json           [验证结果]
     */
    public function checkToken($uid, $token)
    {
        $token2 = $token;
        #获取配置文件中Token验证参数
        $auth = Yii::$app->params['auth'];
        #获取Token生成时的加密密码
        $secret = $auth['key'] . $uid;
        if(!$token){
            $res = $this->error('401', 'Token已过期');
        }
        #base64解码token
        $token = base64_decode($token);

        #Yii解密算法获取加密数据(参数1:Token 参数2:Token生成时设置的密码)
        #失败返回false,成功返回Token
        $data = Yii::$app->getSecurity()->decryptByPassword($token, $secret);
        if (!$data) {
            $res = $this->error('401', 'Token验证失败');
        } else {
            $data = explode('O_O', $data);
            #检测Token数据完整性[包含加密密钥&时间]
            if (count($data) != 2) {
                $res = $this->error('401', 'Token验证失败');
            } else {
                #检测时间超时机制
                if (time() - $data[1] > $auth['timeout']) {
                    $res = $this->error('401', 'Token已过期');
                } else {
                    #检测加密密钥
                    $secret = md5(md5($auth['secret'] . $data[1]));
                    if ($secret == $data[0]) {
                        $res = $this->success();
                    } else {
                        $res = $this->error('401', '密钥出错');
                    }
                }
            }
        }
        // 验证通过后再次更新redis时间
        \Yii::$app->redis->expire($token2,2*60*60); // 设置过期时间 俩小时
//        var_dump(\Yii::$app->redis->ttl($token2));die;
        return $res;
    }

    /**
     * 成功信息
     * @param Array $data 查询数据
     * @return Array 返回请求页面数据
     */
    public function success($data = '')
    {
        return array(
            'code' => '200',
            'message' => 'Token验证成功',
            'data' => $data
        );
    }

    /**
     * 错误信息
     * @param Array $msg 提示消息
     * @return Array 返回请求页面数据
     */
    public function error($code, $msg = '查询失败', $data = '')
    {
        return array(
            'code' => $code,
            'message' => $msg,
            'data' => $data
        );
    }

}

?>

