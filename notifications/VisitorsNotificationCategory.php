<?php

namespace humhub\modules\visitors\notifications;

use Yii;
use humhub\modules\notification\components\NotificationCategory;
use humhub\modules\notification\targets\BaseTarget;
use humhub\modules\notification\targets\MailTarget;
use humhub\modules\notification\targets\WebTarget;
use humhub\modules\notification\targets\MobileTarget;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\friendship\notifications
 */
class VisitorsNotificationCategory extends NotificationCategory
{
    /**
     * Category Id
     * @var string 
     */
    public $id = 'visitors';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('VisitorsModule.notifications_VisitorsNotificationCategory', 'Visitors');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('VisitorsModule.notifications_VisitorsNotificationCategory', 'Receive Notifications for Profile Views.');
    }

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target->id === MailTarget::getId()) {
            return true;
        } else if ($target->id === WebTarget::getId()) {
            return true;
        } else if ($target->id === MobileTarget::getId()) {
            return true;
        }

        return $target->defaultSetting;
    }
}
