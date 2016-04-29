<?php

use yii\helpers\Html;
use yii\web\View;
use matacms\widgets\ActiveForm;
use matacms\widgets\videourl\models\VideoUrlForm;

\matacms\carousel\assets\CarouselAsset::register($this);
?>

<div>
    <div id="media-type-buttons">
        <?php if($mediaTypes['image']): ?>
            <div id="upload-image-container-modal">
            <?php
            $fieldType = !empty($fieldType) ? $fieldType = '&fieldType='.$fieldType : '';
            ?>
            <?= mata\widgets\fineuploader\FineUploader::widget([
                'name' => 'CarouselItemMedia',
                'id' => 'fineuploader-carousel-'.$carouselId,
                'uploadSuccessEndpoint' => '/mata-cms/carousel/carousel-item/upload-successful?carouselId='.$carouselId,
                'view' => '@vendor/matacms/matacms-carousel/views/carousel/_fineuploaderForModal',
                'events' => [
                    'complete' => "$('<li role=\"option\" aria-grabbed=\"false\" draggable=\"true\"><div class=\"grid-item\" data-item-id=\"' + uploadSuccessResponse.Id + '\"><figure class=\"effect-winston\" style=\"background-image:url(' + uploadSuccessResponse.URI + ');\"><figcaption><div class=\"caption-text\"><span> </span><div class=\"fadding-container\"> </div> </div><p><a href=\"#\" class=\"edit-media\" data-title=\"Edit Media\" data-url=\"/mata-cms/carousel/carousel-item/update?id='+uploadSuccessResponse.Id+'\&widgetId=".$widgetId.$fieldType."\" data-source=\"\" data-toggle=\"modal\" data-target=\"#media-modal\"><span></span></a><a href=\"#\" class=\"delete-media\" data-url=\"/mata-cms/carousel/carousel-item/delete?id='+uploadSuccessResponse.Id+'\"><span></span></a></p></figcaption></figure></div></li>').insertBefore('#$widgetId-sortable li#add-media-container');
                    $('#$widgetId-sortable').matasortable('reload');
                    $('#media-modal').modal('hide');"
                ]
                ]);
            ?>
            </div>
        <?php endif; ?>
        <?php if($mediaTypes['video']): ?>
            <a href="#" id="add-video-url-button" class="hi-icon-effect-2 video-url">
                <div class="inner-container row">
                    <div class="five columns">
                        <div class="hi-icon hi-icon-cog"></div>
                    </div>
                    <div class="seven columns">
                        <span> ADD VIDEO URL </span>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>
    <?php if($mediaTypes['video']): ?>
        <div id="add-video-url-container">
           <?= matacms\widgets\videourl\VideoUrl::widget([
            'name' => 'CarouselItemMediaVideoUrl',
            'endpoint' => '/mata-cms/carousel/carousel-item/process-video-url?carouselId='.$carouselId,
            'onComplete' => "$('<li role=\"option\" aria-grabbed=\"false\" draggable=\"true\"><div class=\"grid-item\" data-item-id=\"' + data.Id + '\"><figure class=\"effect-winston\" style=\"background-image:url(' + data.Extra.thumbnailUrl + ');\"><figcaption><div class=\"caption-text\"><span> </span><div class=\"fadding-container\"> </div> </div><p><a href=\"#\" class=\"edit-media\" data-title=\"Edit Media\" data-url=\"/mata-cms/carousel/carousel-item/update?id='+data.Id+'\&widgetId=".$widgetId.$fieldType."\" data-source=\"\" data-toggle=\"modal\" data-target=\"#media-modal\"><span></span></a><a href=\"#\" class=\"delete-media\" data-url=\"/mata-cms/carousel/carousel-item/delete?id='+data.Id+'\"><span></span></a></p></figcaption></figure></div></li>').insertBefore('#$widgetId-sortable li#add-media-container');
            $('#$widgetId-sortable').matasortable('reload');
            $('#media-modal').modal('hide');"
            ]);
            ?>
        </div>
    <?php endif; ?>
</div>
