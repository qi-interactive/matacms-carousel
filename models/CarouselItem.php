<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel\models;

use Yii;
use matacms\carousel\models\Carousel;
use mata\media\models\Media;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "matacms_carouselitem".
 *
 * @property integer $Id
 * @property integer $CarouselId
 * @property string $Caption
 * @property integer $Order
 */

class CarouselItem extends \matacms\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%matacms_carouselitem}}';
    }

    public function behaviors() {
        return [
            [
                'class' => \mata\arhistory\behaviors\HistoryBehavior::className()
            ]
        ];
    }

    public function rules()
    {
        return [
            [['CarouselId'], 'required'],
            [['CarouselId', 'Order'], 'integer'],
            [['Caption'], 'string'],
            [['Language'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'CarouselId' => 'Carousel ID',
            'Caption' => 'Caption',
            'Order' => 'Order'
        ];
    }

    public function getCarousel() {
        return $this->hasOne(Carousel::className(), ['Id' => 'CarouselId']);
    }

    public function getMedia() {
        return Media::find()->forItem($this)->one();
    }

    public function beforeSave($insert) {
        if($insert) {
            $lastOrder = $this->owner->find()->select(sprintf("MAX(`%s`)", 'Order'))->where([
                'CarouselId' => $this->owner->CarouselId
            ])->scalar();
            $this->owner->Order = $lastOrder+1;
        }
        return parent::beforeSave($insert);
    }

    public function afterDelete() {
        Media::find()->forItem($this)->one()->delete();
        return parent::afterDelete();
    }

}
