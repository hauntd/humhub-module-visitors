<?php

namespace humhub\modules\visitors\controllers;

use Yii;
use yii\data\Pagination;
use humhub\components\behaviors\AccessControl;
use humhub\modules\visitors\models\Visit;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors\controllers
 */
class ListController extends \humhub\components\Controller
{
    /**
     * @var int
     */
    public $pageSize = 10;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::className(),
                'loggedInOnly' => true,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $query = Visit::getVisitorsQueryFor(Yii::$app->user->id);
        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $this->pageSize]);
        $query->offset($pagination->offset)->limit($pagination->limit);
        $visits = $query->all();

        return $this->renderAjax('list', [
            'visits' => $visits,
            'pagination' => $pagination,
        ]);
    }
}
