<?php
namespace frontend\controllers;


use common\models\News;
use common\models\Team;
use common\models\Widget;
use common\models\WidgetType;

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
        $unit = Widget::find()->orderBy(['id'=>SORT_ASC])->asArray()->all();
        $news = News::find()->orderBy(['id'=>SORT_ASC])->asArray()->all();
        return $this->renderPartial('index',compact('unit','news'));
    }

    public function actionSearch()
    {
        $data = WidgetType::find()->orderBy(['type_id'=>SORT_ASC])->asArray()->all();
        return $this->renderPartial('search',compact('data'));
    }
}
