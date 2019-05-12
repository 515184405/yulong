<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\LoginForm;

/**
 * Site controller
 */
class LoginController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}