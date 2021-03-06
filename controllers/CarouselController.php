<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel\controllers;

use yii;
use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselSearch;
use matacms\carousel\models\CarouselItem;
use matacms\controllers\module\Controller;
use matacms\carousel\clients\CarouselClient;

class CarouselController extends Controller 
{

    public function getModel() 
    {
        return new Carousel();
    }

    public function getSearchModel() 
    {
        return new CarouselSearch();
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        return $this->actionManage($model->Region);
    }

	/**
     * Lists all CarouselItem models.
     * @return mixed
     */
    
    public function actionManage($region) 
    {
    	$carouselClient = new CarouselClient;
    	$carouselModel = $carouselClient->findByRegion($region);
        
        return $this->render('manage', [
        	'carouselModel' => $carouselModel,
            'carouselItemsModel' => $carouselModel->items
            ]);
    }

}
