<?php

namespace humhub\modules\visitors;

use Yii;
use humhub\modules\user\controllers\ProfileController;
use humhub\modules\visitors\models\Visit;
use humhub\modules\visitors\widgets\Sidebar;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors
 */
class Events extends \yii\base\Object
{
    /**
     * @param $event \yii\base\Event
     */
    public static function onBeforeProfileShow($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        /** @var ProfileController $controller */
        $controller = $event->sender;
        $user = $controller->getUser();

        if ($controller->action->id !== 'index' || Yii::$app->user->id == $user->id) {
            return;
        } else {
            Visit::addVisit($user->id, Yii::$app->user->id);
        }
    }

    /**
     * @param $event \yii\base\Event
     */
    public static function onSidebarInit($event)
    {
        if (!Yii::$app->user->isGuest) {
            $event->sender->addWidget(Sidebar::className(), [], [
                'sortOrder' => 100
            ]);
        }
    }
}
