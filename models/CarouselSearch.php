<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use matacms\carousel\models\Carousel;

/**
 * CarouselSearch represents the model behind the search form about `matacms\carousel\models\Carousel`.
 */

class CarouselSearch extends Carousel {

    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['Title', 'Region'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Carousel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Id' => $this->Id,
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title])
            ->andFilterWhere(['like', 'Region', $this->Region])
            ->andWhere('IsDraft != 1')
            ->andWhere("Region not like 'matacms\\\\\\\\%'");

        return $dataProvider;
    }
    
}
