<?php
/**
 * Created by PhpStorm.
 * User: ghb
 * Date: 18-1-4
 * 阿里云OSS上传
 */

namespace common\components;
use OSS\Core\OssException;
use Yii;
use yii\base\Component;
use OSS\OssClient;

class Aliyunoss extends Component
{
    public static $oss;

    public function __construct()
    {
        parent::__construct();
        $accessKeyId = Yii::$app->params['oss']['accessKeyId'];                 //获取阿里云oss的accessKeyId
        $accessKeySecret = Yii::$app->params['oss']['accessKeySecret'];         //获取阿里云oss的accessKeySecret
        $endpoint = Yii::$app->params['oss']['endPoint'];                       //获取阿里云oss的endPoint
        self::$osswruiop= new OssClient($accessKeyId, $accessKeySecret, $endpoint);  //实例化OssClient对象
        self::$oss->setUseSSL(true);
    }

    /**
     * 使用阿里云oss上传文件
     * @param $object   保存到阿里云oss的文件名
     * @param $filepath 文件在本地的绝对路径
     * @return bool     上传是否成功
     */
    public function upload($object, $filepath)
    {
        $res = false;
        $bucket = Yii::$app->params['oss']['bucket'];               //获取阿里云oss的bucket
        if (self::$oss->uploadFile($bucket, $object, $filepath)) {  //调用uploadFile方法把服务器文件上传到阿里云oss
            $res = true;
        }

        return $res;
    }

    /**
     * 删除指定文件
     * @param $object 被删除的文件名
     * @return bool   删除是否成功
     */
    public function delete($object)
    {
        $res = false;
        $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket
        if (self::$oss->deleteObjects($bucket, $object)){ //调用deleteObject方法把服务器文件上传到阿里云oss
            $res = true;
        }

        return $res;
    }

    /**
     * @param $fileSrc 目录地址
     * 删除当前文件夹下所有的图片
     */
    public function deleteDir($fileSrc){
        $nextMarker = '';
        $deleteArr = [];
        while (true) {
            try {
                $options = array(
                    'delimiter' => '',
                    'marker' => $nextMarker,
                );
                $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket
                $listObjectInfo = self::$oss->listObjects($bucket, $options);
            } catch (OssException $e) {
                printf(__FUNCTION__ . ": FAILED\n");
                printf($e->getMessage() . "\n");
                return;
            }
            // 得到nextMarker，从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表。
            $nextMarker = $listObjectInfo->getNextMarker();
            $listObject = $listObjectInfo->getObjectList();
            $listPrefix = $listObjectInfo->getPrefixList();

            if (!empty($listObject)) {
//                print("objectList:\n");
                foreach ($listObject as $objectInfo) {
//                    print($objectInfo->getKey() . "\n");
                    $deleteArr[] = $objectInfo->getKey();
                }
            }
            if (!empty($listPrefix)) {
//                print("prefixList: \n");
                foreach ($listPrefix as $prefixInfo) {
                    print($prefixInfo->getPrefix() . "\n");
                }
            }
            if ($listObjectInfo->getIsTruncated() !== "true") {
                break;
            }
        }
        return self::delete($deleteArr);
    }

    /**
     * 文件签名
     * @param $object
     * @param $options
     * @param $time -链接生效时间
     * @return string
     */
    public function sign($object, $options = [], $time = 3600){
        $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket
        $options[OssClient::OSS_PROCESS] = 'imm/previewdoc';
        self::$oss->setUseSSL(true);
        $res = self::$oss->signUrl($bucket, $object, $time, 'GET', $options);

        return $res;
    }

    /**
     * 下载文件到本地
     * @param $object
     * @param $download_file  本地目录
     * @return string
     */
    public function download($object, $download_file){
        $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket

        $options = [
            OssClient::OSS_FILE_DOWNLOAD => $download_file,
        ];
        return self::$oss->getObject($bucket, $object, $options);
    }

    /**
     * 下载文件到内存
     * @param $object
     * @return string
     */
    public function downloadMemory($object){
        $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket

        $options = ['response-content-disposition' => "attachment"];
        return self::$oss->signUrl($bucket, $object, 7200, 'GET', $options);
    }

    public function test(){
        echo 123;
        echo "success";
    }
}