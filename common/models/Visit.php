<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property string $ip
 * @property string $time 访问时间
 * @property string $browser 浏览器类型
 * @property string $terminal 终端类型
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'time', 'browser', 'terminal'], 'required'],
            [['time'], 'safe'],
            [['ip'], 'string', 'max' => 30],
            [['browser', 'terminal'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'time' => 'Time',
            'browser' => 'Browser',
            'terminal' => 'Terminal',
        ];
    }

    //判断两天是否是同一天
    function isDiffDays($last_date,$this_date){

        if(($last_date['year']===$this_date['year'])&&($this_date['yday']===$last_date['yday'])){
            return true;
        }else{
            return false;
        }
    }

    //判断是否是移动端
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }

    //获取浏览器信息
    public function getBrowser(){
        $agent=$_SERVER["HTTP_USER_AGENT"];
        if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
            return "ie";
        else if(strpos($agent,'Firefox')!==false)
            return "firefox";
        else if(strpos($agent,'Chrome')!==false)
            return "chrome";
        else if(strpos($agent,'Opera')!==false)
            return 'opera';
        else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
            return 'safari';
        else
            return '其他浏览器';
    }

    public static function addZero($num){
        return $num >= 10 ? $num : '0'.$num;
    }

    //获取浏览器访问分布图
    public static function browser(){
        $model = Visit::find()->asArray()->all();
        $browserData = [];
        foreach ($model as $key => $val){
            if(isset($browserData[$val['browser']])){
                $browserData[$val['browser']] += 1;
            }else{
                $browserData[$val['browser']] = 1;
            }
        }
        return json_encode($browserData);
    }

    //查询昨天访客量
    public static function todayCount(){
        $today =  date("Y-m-d",time());
        $model = Visit::find()->where(['like','time',$today])->asArray()->all();
        $visitArr = [];
        foreach ($model as $key => $val){
            $hour = getdate(strtotime($val['time']));
            $hour = $hour['hours'];
            $time = self::addZero($hour);
            $visitArr[$time][] = $val;
        }
        return json_encode($visitArr);
    }

    //获取用户访问信息
    public static function insertUpdate(){
        $model = new static();
        $user_id = Yii::$app->user->id;
        $ip = $user_id ? $user_id : $_SERVER['REMOTE_ADDR'];
        $modelOne = $model->find()->where(['or',['ip'=>$ip],['ip'=>$user_id]])->orderBy(['id'=>SORT_DESC])->one();
        $nowDate = getdate(time());
        if($modelOne){
            $last_time = getdate(strtotime($modelOne['time']));
            if($model->isDiffDays($nowDate,$last_time)){
                return false;
            }
        }
        $model->ip = $ip;
        $model->time = date("Y-m-d H:i:s",time());
        $model->browser = $model->getBrowser();
        if($model->getBehaviors()){
            $model->terminal = '手机访问';
        }else{
            $model->terminal = '电脑访问';
        }
        $model->save();
    }
}
