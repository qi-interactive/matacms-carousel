<?php

namespace matacms\carousel\actions;

use Yii;
use yii\web\NotFoundHttpException;

class RearrangeAction extends \mata\actions\RearrangeAction {

	public function run() {
		// Load data and validate
		try {
			$data = Yii::$app->request->post();
			$ids = $data['ids'];
			
			foreach($ids as $index => $id) {
				$carouselItem = $this->model->findOne($id);
				$carouselItem->Order = $index+1;
				if(!$carouselItem->save())
					throw new NotFoundHttpException($carouselItem->getTopError());
			}
			echo "OK";
		} catch (NotFoundHttpException $e) {
			call_user_func_array($this->onValidationErrorHandler, [$this->model, $e]);
			return;
		}
		
	}

}  