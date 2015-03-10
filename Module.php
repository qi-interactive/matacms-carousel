<?php

/*
 * This file is part of the mata project.
 *
 * (c) mata project <http://github.com/mata/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace matacms\carousel;

use mata\base\Module as BaseModule;

/**
 * This is the main module class for the Yii2-user.
 *
 * @property array $modelMap
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Module extends BaseModule {

	public function getNavigation() {
		$carousels = \matacms\carousel\models\Carousel::find()->select(['Title', 'Region'])->all();
		$navigation = [];
		foreach ($carousels as $carousel)
			$navigation[$carousel->Title] = "/mata-cms/carousel/carousel/view?Region=$carousel->Region";
		
		return $navigation;
	}
}