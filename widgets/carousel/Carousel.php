<?php
/**
 * @author: Harry Tang (giaduy@gmail.com)
 * @link: http://www.greyneuron.com
 * @copyright: Grey Neuron
 */

namespace matacms\carousel\widgets\carousel;

use yii\widgets\InputWidget;
use yii\helpers\Json;
use yii\web\View;
use yii\base\InvalidConfigException;
use matacms\carousel\widgets\carousel\CarouselAsset;
use mata\keyvalue\models\KeyValue;
use mata\media\models\Media;
use matacms\widgets\videourl\models\VideoUrlForm;

class Carousel extends InputWidget {

    public $carouselModel;
    public $carouselItemsModel;
    public $selector = null;
    public $htmlOptions = [];
    public $mediaTypes = ['image', 'video'];
    public $captionOptions = [];

    public function init(){
        parent::init();

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->selector = '#' . $this->htmlOptions['id'];

        $this->registerPlugin();
        $this->registerJS();

        echo $this->render('carousel', [
                'carouselModel' => $this->carouselModel,
                'carouselItemsModel' => $this->carouselItemsModel,
                'mediaTypes' => $this->mediaTypes,
                'view' => $this->getView(),
                'widgetId' => $this->htmlOptions['id'],
                'captionOptions' => $this->captionOptions
            ]);

        echo '<input type="hidden" name="CarouselRegions[]" value="' . $this->carouselModel->Region . '">';
    }

    /**
     * Registers plugin and the related events
     */
    protected function registerPlugin()
    {
        $view = $this->getView();
        CarouselAsset::register($view);
    }

    /**
     * Register JS
     */
    protected function registerJS() {
        $options = Json::encode($this->options);
        
    }
} 