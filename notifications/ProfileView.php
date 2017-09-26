<?php

namespace humhub\modules\visitors\notifications;

use Yii;
use yii\bootstrap\Html;
use humhub\modules\notification\components\BaseNotification;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors\notifications
 */
class ProfileView extends BaseNotification
{
    /**
     * @inheritdoc
     */
    public $moduleId = 'visitors';
    /**
     * @inheritdoc
     */
    public $viewName = 'profileView';
    /**
     * @inheritdoc
     */
    public $markAsSeenOnClick = true;

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new VisitorsNotificationCategory();
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->originator->getUrl();
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        return strip_tags($this->html());
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Yii::t('VisitorsModule.notification', '{visitorUser} viewed your profile.', [
            'visitorUser' => Html::tag('strong', Html::encode($this->originator->displayName)),
        ]);
    }
}
