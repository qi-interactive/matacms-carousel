<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

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

    public function rules()
    {
        return [
            [['Title', 'Region'], 'required'],
            [['Title', 'Region'], 'string', 'max' => 128],
            [['Id', 'IsDraft'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Title' => 'Title',
            'Region' => 'Region',
        ];
    }

    public function getItems() {
        return $this->hasMany(CarouselItem::className(), ['CarouselId' => 'Id'])->orderBy('Order ASC');
    }

    public function getVisualRepresentation() {

        $item = $this->getItems()->one();

        if ($item != null)
            return $item->getMedia()->URI;
    }

}

class CarouselQuery extends ActiveQuery {

    public function init()
    {
        parent::init();
        $this->andWhere('IsDraft != 1');
    }

}
