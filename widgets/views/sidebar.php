<?php

use yii\helpers\Html;

/* @var $visits[] \humhub\modules\visitors\models\Visit */
?>
<div class="panel panel-default" id="visitors-panel">
    <?php humhub\widgets\PanelMenu::widget(['id' => 'visitors-panel']); ?>
    <div class="panel-heading">
        <?= Yii::t('VisitorsModule.base', '<strong>Users</strong> who visited your profile'); ?>
    </div>
    <div class="panel-body">
        <?php foreach ($visits as $visit): ?>
            <a href="<?= $visit->visitorUser->getUrl(); ?>">
                <img src="<?= $visit->visitorUser->getProfileImage()->getUrl(); ?>"  class="img-rounded tt img_margin" height="40"
                     width="40" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" data-toggle="tooltip"
                     data-placement="top" title="" 
                     data-original-title="<?= Html::encode($visit->visitorUser->displayName); ?>">
            </a>
        <?php endforeach; ?>
        <hr />
        <?= Html::a(Yii::t('VisitorsModule.base', 'Get a list'), ['/visitors/list/list'], array(
            'class' => 'btn btn-info',
            'data-target' => '#globalModal'
        )); ?>
    </div>
</div>

