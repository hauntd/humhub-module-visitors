<?php

use yii\helpers\Html;
use humhub\modules\directory\widgets\MemberActionsButton;

/** @var $visits[] \humhub\modules\visitors\models\Visit */
/** @var $pagination \yii\data\Pagination */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><strong><?= Yii::t('VisitorsModule.views_list', 'Users who visited your profile') ?></strong></h4>
        </div>
        <br>
        <?php if (count($visits)): ?>
        <ul class="media-list">
            <?php foreach ($visits as $visit): ?>
                <li>
                    <div class="pull-right memberActions">
                        <?= MemberActionsButton::widget(['user' => $visit->visitorUser]); ?>
                    </div>
                    <a href="<?= $visit->visitorUser->getUrl(); ?>" style="display: block; overflow: hidden;">
                        <div class="media">
                            <img src="<?= $visit->visitorUser->getProfileImage()->getUrl(); ?>"
                                 class="img-rounded tt img_margin pull-left" height="50" width="50"
                                 alt="50x50" style="width: 50px; height: 50px;"
                                 data-src="holder.js/50x50">
                            <div class="media-body clearfix">
                                <div class="media-heading">
                                    <h4 class="media-heading">
                                        <strong><?= Html::encode($visit->visitorUser->displayName); ?></strong>
                                    </h4>
                                    <h5><?= Html::encode($visit->visitorUser->profile->title); ?></h5>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <p class="text-center"><?= Yii::t('VisitorsModule.views_list', 'You don\'t have any views yet.') ?></p>
        <?php endif; ?>
        <div class="modal-footer" style="padding: 5px">
            <div class="pagination-container">
                <?= \humhub\widgets\AjaxLinkPager::widget(['pagination' => $pagination]); ?>
            </div>
        </div>
    </div>
</div>
