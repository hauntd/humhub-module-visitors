<?php

namespace humhub\modules\visitors;

use Yii;
use humhub\modules\visitors\models\Visit;
use humhub\modules\notification\models\Notification;
use yii\helpers\Url;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors
 */
class Module extends \humhub\components\Module
{
    /**
     * @var int notifications interval
     */
    public $notifyAfter = 3600;

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        return [
            'humhub\modules\visitors\notifications\ProfileView',
        ];
    }

    /**
     * @return int|null|string
     */
    public function getUsersViews()
    {
        if (!Yii::$app->user->isGuest) {
            return Visit::getVisitorsCountFor(Yii::$app->user->id);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getConfigUrl()
    {
        return Url::to(['/visitors/config/config']);
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        Notification::deleteAll(['class' => 'humhub\modules\visitors\notifications\ProfileView']);

        parent::disable();
    }
}
