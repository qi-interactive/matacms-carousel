<?php

namespace matacms\carousel\models;

use Yii;

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
}