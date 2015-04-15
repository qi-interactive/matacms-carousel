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
            <a href="#" id="add-image-button">Upload image</a>
        <?php endif; ?>
        <?php if($mediaTypes['video']): ?>
            <a href="#" id="add-video-url-button">Add video url</a>
        <?php endif; ?>
    </div>
    <?php if($mediaTypes['image']): ?>
        <div id="upload-image-container">
            <?= mata\widgets\fineuploader\FineUploader::widget([
                'name' => 'CarouselItemMedia',
                'uploadSuccessEndpoint' => '/mata-cms/carousel/carousel-item/upload-successful?carouselId='.$carouselId,
                'view' => '@matacms/carousel/views/carousel/_fineuploader',
                'events' => [
                'complete' => "$('<li role=\"option\" aria-grabbed=\"false\" draggable=\"true\"><div class=\"grid-item\" data-item-id=\"' + uploadSuccessResponse.Id + '\"><figure class=\"effect-winston\"><div class=\"img-container\"><img src=\"' + uploadSuccessResponse.URI + '\" draggable=\"false\"></div><figcaption><div class=\"caption-text\"><span> </span><div class=\"fadding-container\"> </div> </div><p><a href=\"#\" class=\"edit-media\" data-title=\"Edit Media\" data-url=\"/mata-cms/carousel/carousel-item/update?id='+uploadSuccessResponse.Id+'\" data-source=\"\" data-toggle=\"modal\" data-target=\"#media-modal\"><span></span></a><a href=\"#\" class=\"delete-media\" data-url=\"/mata-cms/carousel/carousel-item/delete?id='+uploadSuccessResponse.Id+'\"><span></span></a><div class=\"grid-item\" data-item-id=\"'+uploadSuccessResponse.Id+'\"><div class=\"grid-item-centerer\"></div><img src=\"' + uploadSuccessResponse.URI + '\" draggable=\"false\"></div></p></figcaption></figure></div></li>').insertBefore('#$widgetId-sortable li#add-media-container');
                $('#$widgetId-sortable').matasortable('reload');
                $('#media-modal').modal('hide');"
                ]
                ]);
                ?>
            </div>
        <?php endif; ?>
        <?php if($mediaTypes['video']): ?>
            <div id="add-video-url-container">
               <?= matacms\widgets\videourl\VideoUrl::widget([
                'name' => 'CarouselItemMediaVideoUrl',
                'endpoint' => '/mata-cms/carousel/carousel-item/process-video-url?carouselId='.$carouselId,
                'onComplete' => "$('<li role=\"option\" aria-grabbed=\"false\" draggable=\"true\"><a href=\"#\" class=\"edit-media\" data-title=\"Edit Media\" data-url=\"/mata-cms/carousel/carousel-item/update?id='+data.Id+'\" data-source=\"\" data-toggle=\"modal\" data-target=\"#media-modal\"><span class=\"glyphicon glyphicon-pencil\"></span></a><a href=\"#\" class=\"delete-media\" data-url=\"/mata-cms/carousel/carousel-item/delete?id='+data.Id+'\"><span class=\"glyphicon glyphicon-remove\"></span></a><div class=\"grid-item\" data-item-id=\"'+data.Id+'\"><div class=\"grid-item-centerer\"></div><img src=\"' + data.Extra.thumbnailUrl + '\" draggable=\"false\"></div></li>').insertBefore('#$widgetId-sortable li#add-media-container');
                $('#$widgetId-sortable').matasortable('reload');
                $('#media-modal').modal('hide');"
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>