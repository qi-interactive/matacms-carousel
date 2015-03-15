<?php

namespace matacms\carousel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use matacms\carousel\models\CarouselItem;

/**
 * CarouselItemSearch represents the model behind the search form about `matacms\carousel\models\CarouselItem`.
 */
class CarouselItemSearch extends Carousel {
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
        $query = CarouselItem::find();

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

        $query->andFilterWhere(['like', 'Caption', $this->Caption])

        return $dataProvider;
    }
}