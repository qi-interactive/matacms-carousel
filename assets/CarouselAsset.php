<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel\assets;

use yii\web\AssetBundle;

class CarouselAsset extends AssetBundle
{
	public $sourcePath = '@vendor/matacms/matacms-carousel/web';

	public $css = [
        'css/carousel.css'
    ];

	public $js = [
		'js/carousel.js'
	];

	public $depends = [
		'yii\web\YiiAsset'
	];
}
