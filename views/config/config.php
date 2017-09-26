<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model \humhub\modules\visitors\models\ConfigForm */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('VisitorsModule.base', 'Visitors Module Configuration'); ?>
    </div>
    <div class="panel-body">
        <p><?= Yii::t('VisitorsModule.base', 'You may configure the number of visitors to be shown.'); ?></p>
        <br/>
        <?php $form = \yii\bootstrap\ActiveForm::begin(); ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'sidebarUsersLimit') ?>
        <hr>
        <?= Html::submitButton(Yii::t('VisitorsModule.base', 'Save'), array('class' => 'btn btn-primary')); ?>
        <a class="btn btn-default" href="<?php echo Url::to(['/admin/module']); ?>">
            <?= Yii::t('VisitorsModule.base', 'Back to modules'); ?>
        </a>
        <?php \yii\bootstrap\ActiveForm::end() ?>
    </div>
</div>