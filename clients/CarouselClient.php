<?php 

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