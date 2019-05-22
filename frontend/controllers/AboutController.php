<?php
namespace frontend\controllers;


use common\models\Team;

/**
 * Site controller
 */
class AboutController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Team::find()->orderBy(['id'=>SORT_DESC])->asArray()->all();
        return $this->render('index',compact('data'));
    }
}
