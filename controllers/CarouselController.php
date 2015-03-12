<?php

namespace matacms\carousel\controllers;

use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselSearch;
use matacms\carousel\models\CarouselItem;
use matacms\controllers\module\Controller;
use matacms\carousel\clients\CarouselClient;
use mata\widgets\fineuploader\Fineuploader;
use mata\keyvalue\models\KeyValue;
use mata\media\models\Media;
use yii\helpers\Json;

class CarouselController extends Controller {

    public function actions()
    {
        return [
        'rearrangeCarouselItems' => [
                'class' => 'matacms\carousel\actions\RearrangeAction',
                'model' => new CarouselItem(),
                'onValidationErrorHandler' => function() { echo 'ERROR'; }
            ],
        ];
    }

	public function getModel() {
		return new Carousel();
	}

	public function getSearchModel() {
		return new CarouselSearch();
	}

	/**
     * Lists all CarouselItem models.
     * @return mixed
     */
    public function actionManage($region) {
    	$carouselClient = new CarouselClient;
    	$carousel = $carouselClient->findByRegion($region);
        $carouselItems = CarouselItem::find(["Region" => $region])->orderBy('Order ASC')->all();
        
        return $this->render('manage', [
        	'carouselModel' => $carousel,
            'carouselItemsModel' => $carouselItems
        ]);
    }


    /**
     * Create CarouselItem and create media entity for newly created CarouselItem document
     * @return [type] [description]
     */
    
    public function actionUploadSuccessful() {
        $carouselItem = new CarouselItem;
        $carouselItem->CarouselId = \Yii::$app->getRequest()->get("carouselId");
        if ($carouselItem->save() == false)
            throw new CHttpException(500, $carouselItem->getTopError());

        $s3Endpoint = KeyValue::findByKey(FineUploader::S3_ENDPOINT);
        $s3Bucket = KeyValue::findByKey(FineUploader::S3_BUCKET);

        $imageURL = $s3Endpoint .  $s3Bucket  . "/" . urlencode(\Yii::$app->getRequest()->post("key"));
        
        $model = new Media() ;
        $model->attributes = array(
            "Name" => \Yii::$app->getRequest()->post("name"),
            "DocumentId" => $carouselItem->Id,
            "URI" => $imageURL,
            "Width" => 0,
            "Height" => 0,
            "MimeType" => "default"
            );

        if ($model->save() == false)
            throw new CHttpException(500, $model->getTopError());

        $this->setResponseContentType("application/json");
        echo Json::encode($model);
    }
}
