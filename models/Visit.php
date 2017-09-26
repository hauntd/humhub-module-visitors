<?php

namespace humhub\modules\visitors\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Exception;
use humhub\components\ActiveRecord;
use humhub\modules\user\models\User;
use humhub\modules\visitors\notifications\ProfileView;
use humhub\modules\visitors\Module;
use yii\db\Expression;

/**
 * @property integer $id
 * @property integer $target_user_id
 * @property integer $visitor_user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $visitorUser
 * @property User $targetUser
 */
class Visit extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamps' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('now()'),
            ],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['target_user_id', 'visitor_user_id'], 'required'],
            [['target_user_id', 'visitor_user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['target_user_id', 'visitor_user_id'], 'unique',
                'targetAttribute' => ['target_user_id', 'visitor_user_id'],
                'message' => 'The combination of Target User ID and Visitor User ID has already been taken.'
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetUser()
    {
        return $this->hasOne(User::className(), ['id' => 'target_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitorUser()
    {
        return $this->hasOne(User::className(), ['id' => 'visitor_user_id']);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'target_user_id' => Yii::t('VisitorsModule.base', 'Target User'),
            'visitor_user_id' => Yii::t('VisitorsModule.base', 'Visitor User'),
            'created_at' => Yii::t('VisitorsModule.base', 'Created At'),
            'updated_at' => Yii::t('VisitorsModule.base', 'Updated At'),
        ];
    }

    /**
     * @param $targetUserId
     * @param null $limit
     * @return ActiveQuery
     */
    public static function getVisitorsQueryFor($targetUserId, $limit = null)
    {
        $query = static::find()
            ->joinWith(['visitorUser'], true, 'right join')
            ->where(['target_user_id' => $targetUserId])
            ->orderBy('visit.updated_at desc');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * @param $targetUserId
     * @return int|string
     */
    public static function getVisitorsCountFor($targetUserId)
    {
        return self::getVisitorsQueryFor($targetUserId)->count();
    }

    /**
     * @param $targetUserId
     * @param $visitorUserId
     * @throws Exception
     */
    public static function addVisit($targetUserId, $visitorUserId)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('visitors');
        $visit = static::findOne(['visitor_user_id' => $visitorUserId, 'target_user_id' => $targetUserId]);
        $previousVisit = null;
        $newVisit = false;
        if ($visit == null) {
            $visit = new static();
            $visit->target_user_id = $targetUserId;
            $visit->visitor_user_id = $visitorUserId;
            $newVisit = true;
        } else {
            $previousVisit = $visit->updated_at;
        }

        if (!$visit->save()) {
            throw new Exception('Could not save profile visit');
        }

        $visit->refresh();

        if ($previousVisit !== $visit->updated_at) {
            $newestTime  = strtotime($visit->updated_at);
            $previousTime = strtotime($previousVisit);
            if (($newestTime - $previousTime) >= $module->notifyAfter || $newVisit) {
                ProfileView::instance()->from($visit->visitorUser)->about($visit)->send($visit->targetUser);
            }
        }
    }
}
