<?php
namespace frontend\controllers;

/**
 * Site controller
 */
class ServiceController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
