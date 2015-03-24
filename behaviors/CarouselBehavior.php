<?php

namespace matacms\carousel\behaviors;

use Yii;
use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselItem;
use matacms\carousel\clients\CarouselClient;
use matacms\helpers\Html;
use yii\helpers\ArrayHelper;

class CarouselBehavior extends \yii\base\Behavior {

	public function carousel($options = []) {

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		$this->owner->labelOptions["label"] = "Carousel";

		$documentId = $this->owner->model->getDocumentId();

		$pattern = '/([a-zA-Z\\\]*)-([a-zA-Z0-9]*)(::)?([a-zA-Z]*)?/';
		preg_match($pattern, $documentId, $matches);	

		if(!empty($matches) && empty($matches[2])) {
			$pk = uniqid('tmp_');
			if(!empty($matches[4]))
				$pk .= "::" . $matches[4];

			$documentId = $matches[1] . "-" . $pk;
		}

		$carouselClient = new CarouselClient;
		$carouselModel = $carouselClient->findByRegion($documentId);

		if(!$carouselModel) {
			$carouselModel = new Carousel;
			$carouselModel->Title = ($this->owner->model->isNewRecord) ? $documentId : $this->owner->model->getLabel();
			$carouselModel->Region = $documentId;
			if ($carouselModel->save() == false)
				throw new \yii\web\HttpException(500, $carouselModel->getTopError());
		}

		$this->owner->parts['{input}'] = \matacms\carousel\widgets\carousel\Carousel::widget([
			'carouselModel' => $carouselModel,
			'carouselItemsModel' => $carouselModel->items,
			'name' => 'carousel'
			]);


		return $this->owner;
	}

}