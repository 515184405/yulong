<?php
namespace common\helpers;

use yii\web\Response;

class Captcha
{
    public $maxLength = 4;
    public $minLength = 4;
    public $padding = 2;
    public $offset = 10;
    public $testLimit = 1;
    public $width = 100;
    public $height = 34;


    public function captcha() {
        return [
            'class' => 'common\helpers\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            'backColor'=>$this->captcha_color(1), //背景颜色
            'foreColor'=>$this->captcha_color(2),  //字体颜色
            'maxLength' => $this->maxLength,
            //最少显示个数
            'minLength' => $this->minLength,
            //间距
            'padding' => $this->padding,

            //设置字符偏移量
            'offset' => $this->offset,
            'testLimit' => $this->testLimit,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

    //验证码颜色生成 $type 1:backColor背景色 2:foreColor文字颜色
    public function captcha_color($type=1) {
        if(!in_array($type, array(1,2))) $type=1;
        if($type==1) {
            $bg_color_arr=array('15595519','16316664');
            $bg=$bg_color_arr[array_rand($bg_color_arr)];
            return (int) '0x'.$bg;
        } else {
            $text_color_arr=array('12326852','2185586');
            $tc=$text_color_arr[array_rand($text_color_arr)];
            return (int) '0x'.$tc;
        }
    }

}
