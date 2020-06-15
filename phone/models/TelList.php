<?php

namespace phone\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tel_list".
 *
 * @property int $id 手机号id
 * @property int $tel 手机号码
 * @property int $price 单价
 * @property int $online 网络类型
 * @property string $address 归属地
 * @property string $content 套餐信息
 * @property int $user_tel 联系人电话
 * @property int $is_recommend 是否推荐
 */
class TelList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tel_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tel', 'online', 'address', 'user_tel'], 'required'],
            [['price', 'online', 'user_tel', 'is_recommend'], 'integer'],
            [['tel'], 'string', 'max' => 11],
            [['createtime'], 'safe'],
            [['address'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tel' => 'Tel',
            'price' => 'Price',
            'online' => 'Online',
            'address' => 'Address',
            'content' => 'Content',
            'user_tel' => 'User Tel',
            'createtime' => 'Createtime',
            'is_recommend' => 'Is Recommend',
        ];
    }

    /**
     * 检查是否重复
     * @param $mobile
     * @param $meeting_id
     * @return null|static
     */
    public static function IsMobile($mobile)
    {

        $is_mobile = TelList::findOne(['tel' => $mobile]);
        return $is_mobile;
    }

    /*关联用户表*/
    public function getUserInfo(){
        return $this->hasOne(TelContact::className(),['id'=>'user_tel']);
    }

    //查询与搜索
    public static function search($params){
        $query = static::find()->joinWith('userInfo');

        $limit = isset($params['limit']) ? 100 : $params['limit'];
        $page = isset($params['page']) ? 1 : $params['page'];

        $tel = isset($params['tel']) ? $params['tel'] : '';
        //按title status查找
        if(isset($params['tel'])){
            $query->andFilterWhere(['like','tel_list.tel',$params['tel']]);
        }
        /* 网络筛选 */
        if(isset($params['online']) && $params['online'] != '0' && $params['online'] != ''){
            $query->andFilterWhere(['=','tel_list.online',$params['online']]);
        }
        /* 归属地筛选 */
        if(isset($params['address']) && $params['address'] != '0' && $params['address'] != ''){
            $query->andFilterWhere(['=','tel_list.address',$params['address']]);
        }
        /* 手机号价格筛选 */
        if(isset($params['price']) && $params['price'] !='0' && $params['price'] != ''){
            switch ($params['price']){
                case 'DESC' :
                    $query->orderBy(['price' => SORT_DESC]);
                    break;
                case 'ACE' :
                    $query->orderBy(['price' => SORT_ASC]);
                    break;
                default:
                    $price = explode("-",$params['price']);
                    $min = $price[0];
                    $max = $price[1];
                    if($min != ''){
                        $query->andFilterWhere(['>','price',$min]);
                    }
                    if($max != ''){
                        $query->andFilterWhere(['<','price',$max]);
                    }
                    break;
            }
        }

        if(isset($params['search_number']) && $params['search_number'] != '0' && $params['search_number'] != ''){

            $data = $query->asArray()->all();
            /* 模糊搜索 */
            if($params['search_type'] == 1){
                $tel_reg = '#';
                if(strstr($params['search_number'], '尾')){
                    $tel_reg = '$#';
                    $params['search_number'] = str_replace('尾','',$params['search_number']);
                };
                $result = [];
                foreach ($data as $key => $item) {
                    if(preg_match('#'.$params['search_number'].$tel_reg, $item['tel'],$is_tel_bool)){
                        $item['tel'] = preg_replace('#'.$is_tel_bool[0].$tel_reg,'<span style="color:#f00">'.$is_tel_bool[0].'</span>',$item['tel']);
                        $result[] = $item;
                    }
                }
                return self::setPageFun($result,$limit,$page);

            /* 按位搜索 */
            }elseif($params['search_type'] == 2){
                $tel_reg = str_replace('*','\d',$params['search_number']);
                $result = [];
                foreach ($data as $key => $item) {
                    if(preg_match('#'.$tel_reg.'#', $item['tel'],$is_tel_bool)){
                        $result[] = $item;
                    }
                }
                return self::setPageFun($result,$limit,$page);
            }

        }
        /* 手机号类型筛选 */
        if(isset($params['type']) && $params['type'] != '0' && $params['type'] != ''){
            $data = $query->asArray()->all();
            $tel_rule = array(
                'AA' => '([\d])\1{1}',
                'AAA' => '([\d])\1{2}',
                'AAAA' => '([\d])\1{3}',
                'AAAAA' => '([\d])\1{4}',
                'AAAAAA' => '([\d])\1{5}',
                'AAAAAAA' => '([\d])\1{6}',
                'AAAAAAAA' => '([\d])\1{7}',
                'AAAAAAAAA' => '([\d])\1{8}',
                'AAAAAAAAAA' => '([\d])\1{9}',
                'ABC' => '(123|234|345|456|567|678|789|012)',
                'ABCD' => '(1234|2345|3456|4567|5678|6789|0123)',
                'ABCDE' => '(12345|23456|34567|45678|56789|01234)',
                'ABCDEF' => '(123456|234567|345678|456789|012345)',
                'ABCDEFG' => '(1234567|2345678|3456789|0123456)',
                'ABCDEFGH' => '(12345678|23456789|01234567)',
                'AAB' => '(\d)\1((?!\1)\d)',
                'AABB' => '(\d)\1(\d)\2',
                'AABBB' => '(\d)\1((?!\1)\d{3})',
                'AABBBB' => '(\d)\1((?!\1)\d{4})',
                'AABBBBB' => '(\d)\1((?!\1)\d{5})',
                'AABBBBBB' => '(\d)\1((?!\1)\d{6})',
                'AAAB' => '(\d)\1{2}((?!\1)\d)',
                'AAABB' => '(\d)\1{2}((?!\1)\d{2})',
                'AAABBB' => '(\d)\1{2}((?!\1)\d{3})',
                'AAABBBB' => '(\d)\1{2}((?!\1)\d{4})',
                'AAABBBBB' => '(\d)\1{2}((?!\1)\d{5})',
                'AAAAB' => '(\d)\1{3}((?!\1)\d)',
                'AAAABB' => '(\d)\1{3}((?!\1)\d{2})',
                'AAAABBB' => '(\d)\1{3}((?!\1)\d{3})',
                'AAAABBBB' => '(\d)\1{3}((?!\1)\d{4})',
                'AAAAAB' => '(\d)\1{4}((?!\1)\d)',
                'AAAAABB' => '(\d)\1{4}((?!\1)\d\d)',
                'AAAAABBB' => '(\d)\1{4}((?!\1)\d\d\d)',
                'AAAAAAB' => '(\d)\1{5}((?!\1)\d)',
                'AAAAAABB' => '(\d)\1{5}((?!\1)\d\d)',
                'AAAAAAAB' => '(\d)\1{6}((?!\1)\d)',
                'ABAB' => '(\d)(\d)\1((?!\1)\2)',
                'ABCABC' => '([\d]{3})\1',
                'ABCDABCD' => '([\d]{4})\1',
            );
            $result = [];
            foreach ($data as $key => $item) {
                $tel_key_arr = explode('-',$params['type']);
                for($i = 0; $i < count($tel_key_arr);$i++){
                    if(strstr($params['type'], '尾')){
                        $tel_key = str_replace('尾','',$tel_key_arr[$i]);
                        $tel_reg = '#'.$tel_rule[$tel_key].'$#';
                        if(preg_match($tel_reg, $item['tel'],$is_tel_bool)){
                            $item['tel'] = preg_replace('#'.$is_tel_bool[0].'$#','<span style="color:#f00">'.$is_tel_bool[0].'</span>',$item['tel']);
                            $result[] = $item;
                        }
                    }else{
                        $tel_key = $tel_key_arr[$i];
                        $tel_reg = '#'.$tel_rule[$tel_key].'#';
                        if(preg_match($tel_reg, $item['tel'],$is_tel_bool)){
                            $item['tel'] = preg_replace('#'.$is_tel_bool[0].'$#','<span style="color:#f00">'.$is_tel_bool[0].'</span>',$item['tel']);
                            $result[] = $item;
                        }
                    }
                }
            }
            return self::setPageFun($result,$limit,$page);
        }

        $count = 0;
        if($limit && $page){
            $offset = $limit * ($page - 1);
            $count = $query->count();
            $query->offset($offset)->limit($limit);
        }
        $data = $query->asArray()->all();
        return compact('count','data');
    }

    // 设置数据分页
    public static function setPageFun($data,$limit,$page){
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'page' => $page-1,
                'pageSize' => $limit
            ],
        ]);
        $count = $provider->getTotalCount(); //获取分页总数
        $data = $provider->getModels(); // 获取分页后的数据
        return compact('count','data');
    }

    // 添加与修改
    public static function insertUpdate($params,$num_id = null){
        $model = new static();
        $now_time= time();
        $params['createtime']= date('Y-m-d H:i:s',$now_time);//2018-11-28 15:29:29
        if($num_id){
            $model = $model::findOne($num_id);
        }
        $model->setAttributes($params);
        if($model->save()){
            if(!$num_id) {
                return Json::encode(array('code' => '100000', 'message' => '添加成功！'));
            }
            return Json::encode(array('code' => '100000', 'message' => '修改成功！'));
        };
        return Json::encode(array('code' => '100001', 'message' => '操作失败！'));
    }

    // 导入并添加
    public static function insertImport($params){
        $header = [
            0 => '手机号',
            1 => '单价',
            2 => '归属地',
        ];
        $reply = array();//重复数据
        if(!empty($_FILES['file'])) {
            $tag_data = \common\helpers\Excel::getExcelData($_FILES['file']['tmp_name']);
            if (count($tag_data) < 2 || $header != $tag_data[1]) {
                return Json::encode(array('code' => '100001', 'message' => '上传文件模板不正确！'));
            }
            unset($tag_data[1]);
            foreach ($tag_data as $k => $v) {    //循环插入
                $model = new static();
                $now_time= time();
                $params['createtime']= date('Y-m-d H:i:s',$now_time);//2018-11-28 15:29:29

                $preg_phone='/^1[3456789]\d{9}$/ims';
                if(preg_match($preg_phone,$v[0]) == false){
                    return Json::encode(array('code' => '100001', 'message' => "手机号" . $v[0] . '格式不正确'));
                }

                if (TelList::isMobile($v[0])) {
                    array_push($reply, array('tel' => $v[0]));
                    continue;
                }

                $model->setAttributes($params);

                $model->tel = isset($v[0]) ? $v[0] : '';
                $model->price = isset($v[1]) ? $v[1] : '';
                $model->address = isset($v[2]) ? $v[2] : $params->address;
                $model->save();
                if ($model->errors) {
                     foreach ($model->errors as $val) {
                         return Json::encode(array('code' => '100001', 'message' => $val[0]));
                     }
                 }
            }
            return Json::encode(array('code' => '100000', 'message' => '导入成功！','reply' => $reply));
        }
        return Json::encode(array('code' => '100001', 'message' => '导入失败'));

    }
}
