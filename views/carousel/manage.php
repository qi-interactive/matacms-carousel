<?php

use yii\helpers\Html;
use kartik\sortable\Sortable;
use yii\bootstrap\Modal;
use mata\media\helpers\MediaHelper;

/* @var $this yii\web\View */
/* @var $model mata\contentblock\models\ContentBlock */

$this->title = $carouselModel->Title;
$this->params['breadcrumbs'][] = $this->title;

\matacms\carousel\assets\CarouselAsset::register($this);
?>
<div class="carousel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Generate sortable items
    $items = [];
    foreach($carouselItemsModel as $carouselItem) {
        $media = $carouselItem->getMedia();
        // $type = MediaHelper::getType($media->MimeType);
       	$items[] = ['content' => '<a href="#" class="edit-media" data-url="/mata-cms/carousel/carousel-item/update?id=' . $carouselItem->Id . '" data-source="" data-toggle="modal" data-target="#edit-media-modal"><span class="glyphicon glyphicon-pencil"></span></a><div class="grid-item" data-item-id="'.$carouselItem->Id.'"><div class="grid-item-centerer"></div>' . MediaHelper::getPreview($media) . '</div>'];
    }
    $items[] =['content' => '<a href="#" id="add-media" data-toggle="modal" data-target="#add-media-modal">+</a>', 'disabled' => true, 'options' => ['style' => 'cursor:text;', 'id' => 'add-media-container']]
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
                    url: "/mata-cms/carousel/carousel-item/rearrange",
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

<?php
Modal::begin([
    'header' => '<h3>ADD MEDIA</h3>',
    'id' => 'add-media-modal'
    ]);
    ?>
<div>
    <div id="media-type-buttons">
        <a href="#" id="add-image-button">Upload image</a>
        <a href="#" id="add-video-url-button">Add video url</a>
    </div>
    <div id="upload-image-container">
        <?= mata\widgets\fineuploader\Fineuploader::widget([
            'name' => 'CarouselItemMedia',
            'uploadSuccessEndpoint' => '/mata-cms/carousel/carousel-item/upload-successful?carouselId='.$carouselModel->Id,
            'view' => '/carousel/_fineuploader',
            'events' => [
                'complete' => "$('<li role=\"option\" aria-grabbed=\"false\" draggable=\"true\"><a href=\"#\" class=\"edit-media\" data-url=\"/mata-cms/carousel/carousel-item/update?id='+uploadSuccessResponse.Id+'\" data-source=\"\" data-toggle=\"modal\" data-target=\"#edit-media-modal\"><span class=\"glyphicon glyphicon-pencil\"></span></a><div class=\"grid-item\" data-item-id=\"'+uploadSuccessResponse.Id+'\"><div class=\"grid-item-centerer\"></div><img src=\"' + uploadSuccessResponse.URI + '\" draggable=\"false\"></div></li>').insertBefore('.carousel-view ul.sortable li#add-media-container');
                $('ul.sortable').sortable('reload');
                $('#add-media-modal').modal('hide');"
            ]
            ]);
        ?>
    </div>
    <div id="add-video-url-container">
         <?= matacms\widgets\videourl\VideoUrl::widget([
            'name' => 'CarouselItemMediaVideoUrl',
            'endpoint' => '/mata-cms/carousel/carousel-item/process-video-url?carouselId='.$carouselModel->Id
            ]);
        ?>
    </div>
</div>
<?php 
Modal::end(); ?>

<?php
Modal::begin([
    'header' => '<h3>EDIT MEDIA</h3>',
    'id' => 'edit-media-modal'
    ]);
    ?>

<?php 
Modal::end(); ?>
