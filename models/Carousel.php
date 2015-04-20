<?php

namespace matacms\carousel\models;

use Yii;
use matacms\carousel\models\CarouselItem;
use yii\db\ActiveQuery;
use mata\arhistory\behaviors\HistoryBehavior;

/**
 * This is the model class for table "matacms_carousel".
 *
 * @property integer $Id
 * @property string $Title
 * @property string $Region
 */
class Carousel extends \matacms\db\ActiveRecord
{

    public static function find() {
        return new CarouselQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%matacms_carousel}}';
    }

    public function behaviors()
    {
        return [
            HistoryBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Title', 'Region'], 'required'],
            [['Title', 'Region'], 'string', 'max' => 128],
            [['Id', 'IsDraft'], 'safe']
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(CarouselItem::className(), ['CarouselId' => 'Id'])->orderBy('Order ASC');
    }

}

class CarouselQuery extends ActiveQuery {

    public function init()
    {
        parent::init();
        $this->andWhere('IsDraft != 1');
    }

}


