<?php
namespace photolive\controllers;


use photolive\models\PhotoList;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionPhotoList(){
        return PhotoList::getList();
    }
}