<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace matacms\carousel\widgets\carousel;

use yii\web\AssetBundle;

class CarouselAsset extends AssetBundle {

    public $sourcePath = '@vendor/matacms/matacms-carousel/widgets/carousel/assets';

    public $js = [

    ];

    public $css = [
        'css/sortable.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
