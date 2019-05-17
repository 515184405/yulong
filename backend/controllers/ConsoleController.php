<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\LoginForm;

/**
 * Site controller
 */
class ConsoleController extends CommonController
{
    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}