<?php

use yii\helpers\Html;
use yii\web\View;
use matacms\widgets\ActiveForm;
use matacms\widgets\videourl\models\VideoUrlForm;

?>

<?php 
$isVideoUrlMedia = in_array($mediaModel->MimeType, ['video/youtube', 'video/vimeo']);
if(!$isVideoUrlMedia): 
?>
<?= mata\widgets\fineuploader\Fineuploader::widget([
    'name' => 'CarouselItemMedia',
    'uploadSuccessEndpoint' => '/mata-cms/carousel/carousel-item/upload-successful?carouselId='.$carouselItemModel->CarouselId.'&carouselItemId='.$carouselItemModel->Id,
    'view' => '/carousel/_fineuploader',
    'model' => $carouselItemModel,
    'events' => [
        'complete' => "$('.grid-item[data-item-id=\"' + uploadSuccessResponse.Id + '\"] img').attr('src', uploadSuccessResponse.URI);"
    ],
    'options' => [
        'multiple' => false
    ]
    ]);
?>
<?php else: ?>
    <?php 
    $formModel = new VideoUrlForm;
    $formModel->videoUrl = $mediaModel->URI;
    ?>
    <?php $videoUrlWidget = matacms\widgets\videourl\VideoUrl::widget([
        'name' => 'CarouselItemMediaVideoUrl',
        'endpoint' => '/mata-cms/carousel/carousel-item/process-video-url?carouselId='.$carouselItemModel->CarouselId.'&carouselItemId='.$carouselItemModel->Id,
        'formModel' => $formModel,
        'onComplete' => "$('.grid-item[data-item-id=\"' + data.Id + '\"] img').attr('src', data.Extra.thumbnailUrl);",
        'options' => [
            'showSubmitButton' => false
        ]
        ]);
    echo $videoUrlWidget;
    ?>

<?php endif; ?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'id' => 'update-carousel-item-form'
    ]); ?>
    <hr>
    <?= $form->field($carouselItemModel, 'Caption'); ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php

    $onBeforeSubmit = "";
    if($isVideoUrlMedia) {
        $onBeforeSubmit = "var videoUrlForm = $('#edit-media-modal .video-url form');
        videoUrlForm.trigger('submit');
        if(videoUrlForm.find('.has-error').length) {
            return false;
        }";
    }

    $this->registerJs("
       $('#" . $form->id . "').on('beforeSubmit', function(event, jqXHR, settings) {
        " . $onBeforeSubmit . "
        
        var form = $(this);
        if(form.find('.has-error').length) {
            return false;
        }  

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.Response == 'OK')
                    $('#edit-media-modal').modal('hide');
            }
        });

    return false;
});", View::POS_READY);

?>
