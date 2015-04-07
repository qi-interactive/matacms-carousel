<?php

namespace matacms\carousel\models;

use Yii;
use matacms\carousel\models\Carousel;
use mata\media\models\Media;
use yii\db\ActiveQuery;
use mata\arhistory\behaviors\HistoryBehavior;

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

    public function behaviors() {
        return [
            HistoryBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%matacms_carouselitem}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CarouselId'], 'required'],
            [['CarouselId', 'Order'], 'integer'],
            [['Caption'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'CarouselId' => 'Carousel ID',
            'Caption' => 'Caption',
            'Order' => 'Order'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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