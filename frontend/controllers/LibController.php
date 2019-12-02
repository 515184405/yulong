<?php
namespace frontend\controllers;

/**
 * Site controller
 */
$arrData = [];
class LibController extends CommonController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */

    public $arrData = array();

    public function actionIndex()
    {
        return $this->render('index');
    }
}
