<?php

    namespace phone\controllers;

    use phone\models\uploadFormExcel;
    use yii\web\Controller;

    class UploadController extends Controller
    {
        public function actionImport()
        {
            $model = new uploadFormExcel();
            
        }
    }