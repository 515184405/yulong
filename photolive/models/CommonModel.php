<?php

namespace photolive\models;

use Yii;

class CommonModel extends \yii\db\ActiveRecord
{
    /**转Json格式
     * @param $code
     * @param $message
     * @param $data
     * @param $count
     * @return string
     */
    public static function convertJson($code, $message, $data = '', $count = null)
    {

        $Json['code'] = $code;
        $Json['message'] = $message;
        $Json['data'] = $data;
        if (!empty($count)) {
            $Json['count'] = $count;
        }
        return json_encode($Json);
    }

    /**
     * 删除方法
     * @param $id
     * @return string
     */
    public static function deleteOne($id){
        if($id){
            static::deleteAll(['id'=>$id]);
            return self::convertJson('100000','删除成功');
        }else{
            return self::convertJson('100001','没有找到要删除的目标');
        }
    }

    /**
     * 查找方法
     * @param array $arr
     * @return string
     */
    public static function getList($arr = []){
        $result = static::find()->where($arr)->asArray()->all();
        return self::convertJson('100000','查询成功',$result);
    }

    /**
     * 新增与更新方法
     * @param $params
     * @return string
     */
    public static function insertUpdate($params){
        $params['id'] = isset($params['id']) ? $params['id'] : '';
        $params['createtime'] = date('Y-m-d H:i:s',time());
        $model = new static();
        if($params['id']) {
            $model = static::findOne($params['id']);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(isset($model->attributes['sort'])){
                $model->updateAll(['sort'=>$model->attributes['id']],['id'=>$model->attributes['id']]);
            }
            return self::convertJson('100000','操作成功');
        }else{
            if ($model->getFirstErrors()) {
                foreach ($model->getFirstErrors() as $val) {
                    return self::convertJson('100001', $val);
                }
            }
            return self::convertJson('100001','操作失败');
        }
    }
}
