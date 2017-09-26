<?php

use humhub\modules\user\controllers\ProfileController;
use humhub\modules\dashboard\widgets\Sidebar;

return [
    'id' => 'visitors',
    'class' => 'humhub\modules\visitors\Module',
    'namespace' => 'humhub\modules\visitors',
    'isCoreModule' => false,
    'events' => [
        [
            'class' => ProfileController::className(),
            'event' => ProfileController::EVENT_BEFORE_ACTION,
            'callback' => ['humhub\modules\visitors\Events', 'onBeforeProfileShow'],
        ],
        [
            'class' => Sidebar::className(),
            'event' => Sidebar::EVENT_INIT,
            'callback' => ['humhub\modules\visitors\Events', 'onSidebarInit']
        ],

    ],
    'urlManagerRules' => []
];
