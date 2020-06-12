<?php
namespace common\helpers;

use Yii;
class Message{

    /**
     * 提示框
     * @param $message string 提示信息
     * @param bool $status 状态:true=正确、false=错误
     * @param string $url 跳转地址
     * @param bool $iframe 跳转链接在主窗口跳转、还是iframe 跳转
     * @return string
     */
    public static function tips($message, $status=false, $url = '', $iframe = false, $time = 3000){
        return Yii::$app->getView()->render('@common/helpers/views/tips', compact('message', 'status', 'url', 'iframe', 'time'));
    }
}
