<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace matacms\carousel\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
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
