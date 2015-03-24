<?php
/** 
 * @author: Harry Tang (giaduy@gmail.com)
 * @link: http://www.greyneuron.com 
 * @copyright: Grey Neuron
 */

namespace matacms\carousel\widgets\carousel;

use yii\web\AssetBundle;


class CarouselAsset extends AssetBundle {

    public $sourcePath = '@matacms/carousel/widgets/carousel/assets';
    public $js = [
        
    ];
    public $css = [
        'css/sortable.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}