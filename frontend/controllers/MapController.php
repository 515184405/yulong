<?php
namespace frontend\controllers;


use common\models\Team;
use common\models\Widget;

/**
 * Site controller
 */
class MapController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Widget::find()->orderBy(['id'=>SORT_ASC])->asArray()->all();
        return $this->renderPartial('index',compact('data'));
    }
}
