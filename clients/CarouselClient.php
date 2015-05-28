<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel\clients;

use matacms\carousel\models\Carousel;

class CarouselClient extends \matacms\clients\SimpleClient {

	public function findByRegion($region) {
		return $this->findByAttributes(["Region" => $region]);
	}

	public function getModel() {
		return new Carousel();
	}
	
}
