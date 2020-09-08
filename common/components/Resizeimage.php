<?php

namespace common\components;

use yii\base\Component;

class Resizeimage extends Component{
    // 重置图片文件大小
    /**
     * @param $filename 文件名
     * @param $tmpname  路径
     * @param $xmax     宽
     * @param $ymax     高
     * @return resource
     */
    public function set_image($filename, $tmpname, $xmax, $ymax)
    {
        $ext = explode(".", $filename);
        $ext = $ext[count($ext)-1];

        if($ext == "jpg" || $ext == "jpeg")
            $im = imagecreatefromjpeg($tmpname);
        elseif($ext == "png")
            $im = imagecreatefrompng($tmpname);
        elseif($ext == "gif")
            $im = imagecreatefromgif($tmpname);

        $x = imagesx($im);
        $y = imagesy($im);

        if($x <= $xmax && $y <= $ymax)
            return $im;

        if($x >= $y) {
            $newx = $xmax;
            $newy = $newx * $y / $x;
        }
        else {
            $newy = $ymax;
            $newx = $x / $y * $newy;
        }

        $im2 = imagecreatetruecolor($newx, $newy);
        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);

        return $im2;
    }
}
?>