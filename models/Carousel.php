<?php

namespace matacms\carousel\models;

use Yii;

/**
 * This is the model class for table "matacms_carousel".
 *
 * @property integer $Id
 * @property string $Title
 * @property string $Region
 */
class Carousel extends \matacms\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'matacms_carousel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Title', 'Region'], 'required'],
            [['Title', 'Region'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Title' => 'Title',
            'Region' => 'Region',
        ];
    }
}