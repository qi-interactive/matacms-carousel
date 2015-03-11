<?php

namespace matacms\carousel\models;

use Yii;
use matacms\carousel\models\Carousel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "matacms_carouselitem".
 *
 * @property integer $Id
 * @property integer $CarouselId
 * @property string $Caption
 */
class CarouselItem extends \matacms\db\ActiveRecord
{
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarousel() {
        return $this->hasOne(Carousel::className(), ['Id' => 'CarouselId']);
    }
}