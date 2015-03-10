<?php

namespace matacms\carousel\controllers;

use matacms\carousel\models\Carousel;
use matacms\carousel\models\CarouselSearch;
use matacms\controllers\module\Controller;

class CarouselController extends Controller {

	public function getModel() {
		return new Carousel();
	}

	public function getSearchModel() {
		return new CarouselSearch();
	}
}
