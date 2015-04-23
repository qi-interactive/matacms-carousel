<?php

use yii\helpers\Html;
use mata\widgets\sortable\Sortable;
use yii\bootstrap\Modal;
use mata\media\helpers\MediaHelper;
use mata\helpers\StringHelper;

\matacms\carousel\assets\CarouselAsset::register($this);

?>
<div class="carousel-view">
    
    <?php
    $widgetIdParam = '&widgetId='.$widgetId;


    $captionOptionsParams = '';
    if(!empty($captionOptions)) {
        foreach($captionOptions as $key => $value)
            $captionOptionsParams .= '&' . $key . '=' . $value;
    }
    // Generate sortable items
    $items = [];
    if(!empty($carouselItemsModel)) {
        foreach($carouselItemsModel as $carouselItem) {
            $media = $carouselItem->getMedia();
            // $type = MediaHelper::getType($media->MimeType);
            $items[] = ['content' => '
            <div class="grid-item" data-item-id="'.$carouselItem->Id.'">
                <figure class="effect-winston"><div class="img-container">' .
                    MediaHelper::getPreview($media) . '</div>
                    <figcaption>
                        <div class="caption-text"><span>'.StringHelper::truncateToCharacter(StringHelper::removeHtmlTags($carouselItem->Caption), 50).'</span><div class="fadding-container"> </div> </div>
                        <p>
                            <a href="#" class="edit-media" data-title="Edit Carousel Slide" data-url="/mata-cms/carousel/carousel-item/update?id=' . $carouselItem->Id . $widgetIdParam . $captionOptionsParams . '" data-source="" data-toggle="modal" data-target="#media-modal">
                                <span></span></a>
                                <a href="#" class="delete-media" data-url="/mata-cms/carousel/carousel-item/delete?id=' . $carouselItem->Id . '"><span class=""></span></a>
                            </p>
                        </figcaption>           
                    </figure>
                </div>
                '];
            }
        }



    // <a href="#" class="delete-media" data-url="/mata-cms/carousel/carousel-item/delete?id=' . $carouselItem->Id . '"><span class="glyphicon glyphicon-remove"></span></a>
    // <div class="grid-item" data-item-id="'.$carouselItem->Id.'"><div class="grid-item-centerer"></div>' . MediaHelper::getPreview($media) . '</div>'

        $mediaTypesParams = '';
        if(!empty($mediaTypes)) {
            foreach($mediaTypes as $mediaType) {
                $mediaTypesParams .= '&' . $mediaType . '=true';
            }
        }

        $items[] =['content' => '<a href="#" id="add-media" data-title="Add Carousel Slide" data-url="/mata-cms/carousel/carousel-item/add-media?carouselId=' . $carouselModel->Id . $widgetIdParam . $captionOptionsParams . $mediaTypesParams . '" data-source="" data-toggle="modal" data-target="#media-modal"><div class="add-media-inner-wrapper"> <div class="hi-icon-effect-2">
        <div class="hi-icon hi-icon-cog"></div>
    </div> <span> CLICK to upload files </span></div></a>', 'disabled' => true, 'options' => ['style' => 'cursor:text;', 'id' => 'add-media-container']]
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
