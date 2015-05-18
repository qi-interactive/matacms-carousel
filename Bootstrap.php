<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel;

use Yii;
use matacms\carousel\behaviors\CarouselBehavior;
use yii\base\Event;
use matacms\widgets\ActiveField;
use mata\base\MessageEvent;
use matacms\carousel\clients\CarouselClient;
//TODO Dependency on matacms
use matacms\controllers\module\Controller;

class Bootstrap extends \mata\base\Bootstrap 
{

	public function bootstrap($app) 
	{
		Event::on(ActiveField::className(), ActiveField::EVENT_INIT_DONE, function(MessageEvent $event) {
			$event->getMessage()->attachBehavior('carousel', new CarouselBehavior());
		});

		Event::on(Controller::class, Controller::EVENT_MODEL_UPDATED, function(\matacms\base\MessageEvent $event) {
			$this->updateRegions($event->getMessage());
		});

		Event::on(Controller::class, Controller::EVENT_MODEL_CREATED, function(\matacms\base\MessageEvent $event) {
			$this->updateRegions($event->getMessage());
		});
	}

	private function updateRegions($model) 
	{
		$tmpRegions = \Yii::$app->request->post('CarouselRegions');
		if(!empty($tmpRegions)) {
			foreach ($tmpRegions as $tmpRegion) {
				$this->updateRegion($model, $tmpRegion);
			}
		}				
	}

	private function updateRegion($model, $tmpRegion)
	{
		$attributePos = strpos($tmpRegion, "::");
		$attribute = '';
		if($attributePos)
			$attribute = substr(substr($tmpRegion, $attributePos), 2);

		$carouselClient = new CarouselClient;
		$carouselModel = $carouselClient->findByRegion($tmpRegion);

		if($tmpRegion && !empty($carouselModel) && $carouselModel->getLabel()) {
			$carouselModel->Title = $model->getLabel();
			$carouselModel->Region = $model->getDocumentId($attribute)->getId();
			$carouselModel->IsDraft = 0;
			if ($carouselModel->save() == false)
				throw new \yii\web\HttpException(500, $carouselModel->getTopError());
		}
	}

	private function canRun($app) 
	{
		return is_a($app, "yii\console\Application") == false;
	}

}
