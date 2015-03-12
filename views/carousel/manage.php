<?php

use yii\helpers\Html;
use kartik\sortable\Sortable;

/* @var $this yii\web\View */
/* @var $model mata\contentblock\models\ContentBlock */

$this->title = $carouselModel->Title;
$this->params['breadcrumbs'][] = $this->title;

\matacms\carousel\assets\ModuleAsset::register($this);
?>
<div class="carousel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    // Generate sortable items
    $items = [];
    foreach($carouselItemsModel as $carouselItem)
    	$items[] = ['content' => '<div class="grid-item" data-item-id="'.$carouselItem->Id.'">'.$carouselItem->Caption.'</div>'];
    // add media placeholder
    $items[] = ['content' => '<div class="grid-item" id="media-upload">'.\mata\widgets\fineuploader\Fineuploader::widget([
        'name' => 'CarouselItemMedia',
        'uploadSuccessEndpoint' => 'upload-successful?carouselId='.$carouselModel->Id,
        'view' => '/carousel/_fineuploader'
      ]).'</div>', 'disabled' => true, 'options' => ['style' => 'cursor:text;', 'class' => 'upload-container']];
    ?>

    <?= Sortable::widget([
    	'type' => 'grid',
    	'items' => $items,
    	'pluginEvents' => [
    		'sortupdate' => 'function(e, ui) { 
    			var items = ui.startparent.children().children(".grid-item");
				var carouselItemsIds = $.map(items, function(i) {
					return $(i).data("item-id");
				});
				$.ajax({
                    type: "POST",
                    url: "rearrangeCarouselItems",
                    data: {"ids":carouselItemsIds},
                    dataType: "json",
                    success: function(data) {
                    	console.log("success");
                    },
                    error: function() {
                    	console.log("error");
                    }
                });
    		}',
		]
    ]); ?>

</div>
