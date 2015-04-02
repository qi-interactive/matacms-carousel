<?php

use yii\helpers\Html;
use mata\widgets\sortable\Sortable;
use yii\bootstrap\Modal;
use mata\media\helpers\MediaHelper;

\matacms\carousel\assets\CarouselAsset::register($this);

?>
<div class="carousel-view">

    <?php

    $widgetIdParam = '&widgetId='.$widgetId;
    // Generate sortable items
    $items = [];
    if(!empty($carouselItemsModel)) {
        foreach($carouselItemsModel as $carouselItem) {
            $media = $carouselItem->getMedia();
            // $type = MediaHelper::getType($media->MimeType);
            $items[] = ['content' => '<a href="#" class="edit-media" data-title="Edit Media" data-url="/mata-cms/carousel/carousel-item/update?id=' . $carouselItem->Id . $widgetIdParam . '" data-source="" data-toggle="modal" data-target="#media-modal"><span class="glyphicon glyphicon-pencil"></span></a><a href="#" class="delete-media" data-url="/mata-cms/carousel/carousel-item/delete?id=' . $carouselItem->Id . '"><span class="glyphicon glyphicon-remove"></span></a><div class="grid-item" data-item-id="'.$carouselItem->Id.'"><div class="grid-item-centerer"></div>' . MediaHelper::getPreview($media) . '</div>'];
        }
    }

    $mediaTypesParams = '';
    if(!empty($mediaTypes)) {
        foreach($mediaTypes as $mediaType) {
            $mediaTypesParams .= '&' . $mediaType . '=true';
        }
    }
    
    $items[] =['content' => '<a href="#" id="add-media" data-title="Add Media" data-url="/mata-cms/carousel/carousel-item/add-media?carouselId=' . $carouselModel->Id . $widgetIdParam . $mediaTypesParams . '" data-source="" data-toggle="modal" data-target="#media-modal">+</a>', 'disabled' => true, 'options' => ['style' => 'cursor:text;', 'id' => 'add-media-container']]
    ?>
    
    <?= Sortable::widget([
        'type' => 'grid',
        'id' => $widgetId.'-sortable',
        'items' => $items,
        'pluginEvents' => [
            'sort-update' => 'function(e, ui) { 
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

<?php Modal::begin([
    'header' => '<h3></h3>',
    'id' => 'media-modal'
    ]);
    ?>

<?php Modal::end(); ?>
