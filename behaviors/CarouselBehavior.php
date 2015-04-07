<?php

namespace matacms\carousel\behaviors;

use Yii;
use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselItem;
use matacms\carousel\clients\CarouselClient;
use matacms\helpers\Html;
use yii\helpers\ArrayHelper;
use mata\media\models\Media;
use matacms\widgets\videourl\helpers\VideoUrlHelper;

class CarouselBehavior extends \yii\base\Behavior {

	public function carousel($options = []) {

		$mediaTypes = ['image', 'video'];

		if(isset($options['mediaTypes']))
			$mediaTypes = $options['mediaTypes'];

		$defaultItems = [];

		if(isset($options['defaultItems']))
			$defaultItems = $options['defaultItems'];

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		// $this->owner->labelOptions["label"] = $this->owner->attribute;

		$documentId = $this->owner->model->getDocumentId($this->owner->attribute);

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
			if($this->owner->model->isNewRecord)
				$carouselModel->IsDraft = 1;
			
			if ($carouselModel->save() == false)
				throw new \yii\web\HttpException(500, $carouselModel->getTopError());

			if(!empty($defaultItems)) {
				foreach($defaultItems as $defaultItem) {
					$this->createDefaultCarouselItem($defaultItem, $carouselModel);
				}
			}
		}


		$this->owner->parts['{input}'] = \matacms\carousel\widgets\carousel\Carousel::widget([
			'carouselModel' => $carouselModel,
			'carouselItemsModel' => $carouselModel->items,
			'name' => 'carousel',
			'mediaTypes' => $mediaTypes
			]);


		return $this->owner;
	}

	protected function createDefaultCarouselItem($item, $carouselModel)
	{
		$itemType = $item['type'];

		$carouselItemModel = new CarouselItem;
        $carouselItemModel->CarouselId = $carouselModel->Id;
        if(!empty($item['caption']))
        	$carouselItemModel->Caption = $item['caption'];

        if ($carouselItemModel->save() == false)
            throw new \yii\web\HttpException(500, $carouselItemModel->getTopError());

		if($itemType == 'image') {
			$imageURL = $item['URI'];
			$fileName = basename($imageURL);

			$mediaWidth = 0; 
	        $mediaHeight = 0;
	        $mimeType = "default";

	        $imageAttributes = getimagesize($imageURL);

	        if ($imageAttributes != null) {
	            $mediaWidth = $imageAttributes[0];
	            $mediaHeight = $imageAttributes[1];
	            $mimeType = $imageAttributes['mime'];
	        } else {
	            $ch = curl_init($imageURL);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            curl_exec($ch);
	            $mimeType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	        }

	        $mediaModel = new Media() ;
            $mediaModel->attributes = array(
                "Name" => $fileName,
                "DocumentId" => $carouselItemModel->getDocumentId()->getId(),
                "URI" => $imageURL,
                "Width" => $mediaWidth,
                "Height" => $mediaHeight,
                "MimeType" => $mimeType
                );

            if ($mediaModel->save() == false)
            	throw new \yii\web\HttpException(500, $mediaModel->getTopError());

		} elseif($itemType == 'video') {
			$videoURL = $item['URI'];

			$mediaModel = new Media() ;
            $mediaModel->attributes = array(
                "Name" => $videoURL,
                "DocumentId" => $carouselItemModel->getDocumentId()->getId(),
                "URI" => $videoURL,
                "Width" => 0,
                "Height" => 0,
                "MimeType" => $this->identifyVideoServiceProvider($videoUrlForm->videoUrl),
                "Extra" => Json::encode(['thumbnailUrl' => VideoUrlHelper::getPicture($videoURL)])
            );
            if ($mediaModel->save() == false)
                throw new \yii\web\HttpException(500, $mediaModel->getTopError());
		}		
	}

	protected function identifyVideoServiceProvider($value) 
    {
        $url = preg_replace('#\#.*$#', '', trim($value));
        $services_regexp = [
        '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/'     => 'vimeo',
        '/(?:https?:\/\/)?(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=)?([\w-]{10,})/'     => 'youtube'
        ];

        foreach ($services_regexp as $pattern => $service) {
            if(preg_match($pattern, $value, $matches)) {
                return 'video/'.$service;
            }
        }

        return "default";
    }

}