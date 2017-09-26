<?php

namespace humhub\modules\visitors\models;

use Yii;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package humhub\modules\visitors\models
 */
class ConfigForm extends \yii\base\Model
{
    /**
     * @var integer
     */
    public $sidebarUsersLimit;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['sidebarUsersLimit', 'required'],
            ['sidebarUsersLimit', 'integer', 'min' => 1, 'max' => 50],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'sidebarUsersLimit' => Yii::t('VisitorsModule.base', 'The number of visitors that will be shown.'),
        ];
    }
}
