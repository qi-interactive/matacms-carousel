<?php

namespace matacms\carousel\controllers;

use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselSearch;
use matacms\carousel\models\CarouselItem;
use matacms\controllers\module\Controller;
use matacms\carousel\clients\CarouselClient;

class CarouselController extends Controller {

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
    public function actionManager($region)
    {
    	$carouselClient = new CarouselClient;
    	$carousel = $carouselClient->findByRegion($region);
        $carouselItems = CarouselItem::find(["Region" => $region])->all();
        
        return $this->render('manage', [
        	'carouselModel' => $carousel,
            'carouselItemsModel' => $carouselItems
        ]);
    }
}
