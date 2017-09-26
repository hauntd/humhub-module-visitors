<?php

namespace humhub\modules\visitors\widgets;

use Yii;
use humhub\modules\visitors\models\Visit;
use humhub\models\Setting;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors\widgets
 */
class Sidebar extends \humhub\components\Widget
{
    /**
     * @return null|string
     */
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }

        $limit = Yii::$app->getModule('visitors')->settings->get('sidebarUsersLimit', 5);
        $visits = Visit::getVisitorsQueryFor(Yii::$app->user->id, $limit)->all();
        if (count($visits) == 0) {
            return null;
        }

        return $this->render('sidebar', ['visits' => $visits]);
    }
}
