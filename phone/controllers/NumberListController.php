<?php
namespace phone\controllers;

use phone\models\TelContact;
use phone\models\TelList;
use Yii;
use yii\helpers\Json;

/**
 * Site controller
 */
class NumberListController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        //读数据
        $params = Yii::$app->request->get();
        if(Yii::$app->request->isAjax){
            $data = TelList::search($params);
            return $this->convertJson('0','查询成功',$data['data'], $data['count']);
        }
        return $this->render('index');
    }
    //创建
    public function actionInfo()
    {
        $num_id = isset($_GET['id']) ? $_GET['id'] : '';
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            if(!empty($_FILES['file']) && !$num_id){
                return TelList::insertImport($params);
            }else{
                return TelList::insertUpdate($params,$num_id);
            }
        }
        $data['number_list'] = [];
        $data['contact'] = TelContact::find()->asArray()->all();
        $data['number_list'] = [];
        //查询number_list数据
        if($num_id){
            $data['number_list'] = TelList::find()->where(['id'=>$num_id])->asArray()->one();
            if(!$data['number_list']){
                return '数据不存在';
            }
        }
        return $this->render('info',compact('data'));
    }

    /**
     * 下载表字段
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function actionDownSample()
    {
        //先生成excel下载
        $header = [
            'tel' => '手机号',
            'price' => '单价',
            'address' => '归属地',
        ];
        //end
        $list = [
            [
            ]
        ];
        $filename = '导入手机号信息表';
        \common\helpers\Excel::createExcelFromData($header, $list, $filename);

    }


    public function actionSwitch(){
        $num_id = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost){
            $params = $_POST;
            //存newsModel数据
            $num_id2 = TelList::insertUpdate($params,$num_id);
            if($num_id2){
                if($num_id){
                    return Json::encode(array('code'=>'100000','message'=>'修改成功！'));
                }
            }
            return Json::encode(array('code'=>'100001','message'=>'添加失败！'));
        }
    }

    public function actionDelete(){
        $num_id = isset($_POST['id']) ? $_POST['id'] : '';
        if(Yii::$app->request->isPost && $num_id){
            TelList::deleteAll(['id'=>$num_id]);
            return Json::encode(['code' => 100000,'message' => '删除成功']);
        }else{
            return Json::encode(['code' => 100000,'message'=> '没有找到要删除的目标']);
        }
    }
}