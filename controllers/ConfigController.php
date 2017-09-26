<?php

namespace humhub\modules\visitors\controllers;

use Yii;
use humhub\modules\visitors\models\ConfigForm;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors\controllers
 */
class ConfigController extends \humhub\modules\admin\components\Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionConfig()
    {
        $settings = Yii::$app->getModule('visitors')->settings;
        $form = new ConfigForm();
        $form->sidebarUsersLimit = $settings->get('sidebarUsersLimit', 5);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $settings->set('sidebarUsersLimit', $form->sidebarUsersLimit);
            return $this->refresh();
        }

        return $this->render('config', array(
            'model' => $form
        ));
    }
}
