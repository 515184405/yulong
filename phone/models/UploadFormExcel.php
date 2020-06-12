<?php
/**
 * 描述...
 * @author zcy
 * @date 2019/8/13
 */

namespace phone\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class uploadFormExcel extends ActiveRecord
{
    public $file;

    public function rules()
    {
        return [
            [['file'],'file', 'skipOnEmpty' => false,'extensions' => 'xls,xlsx'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file'=> '上传文件'
        ];
    }

    public function upload()
    {
        $file = UploadedFile::getInstance($this, 'file');

        if ($this->rules()) {
            $tmp_file = $file->baseName . '.' . $file->extension;
            $path = 'upload/' . 'Files/';
            if (is_dir($path)) {
                $file->saveAs($path . $tmp_file);
            } else {
                mkdir($path, 0777, true);
            }
            $file->saveAs($path . $tmp_file);
            return true;
        } else {
            return '验证失败';
        }
    }

}