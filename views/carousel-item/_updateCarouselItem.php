<?php

use yii\helpers\Html;
use yii\web\View;
use matacms\widgets\ActiveForm;
use matacms\widgets\videourl\models\VideoUrlForm;

?>

<?php if(!in_array($mediaModel->MimeType, ['video/youtube', 'video/vimeo'])): ?>
<?= mata\widgets\fineuploader\Fineuploader::widget([
    'name' => 'CarouselItemMedia',
    'uploadSuccessEndpoint' => '/mata-cms/carousel/carousel-item/upload-successful?carouselId='.$carouselItemModel->CarouselId.'&carouselItemId='.$carouselItemModel->Id,
    'view' => '/carousel/_fineuploader',
    'model' => $carouselItemModel,
    'events' => [
        'complete' => ""
    ]
    ]);
?>
<?php else: ?>
    <?php 
    $formModel = new VideoUrlForm;
    $formModel->videoUrl = $mediaModel->URI;
    ?>
    <?= matacms\widgets\videourl\VideoUrl::widget([
        'name' => 'CarouselItemMediaVideoUrl',
        'endpoint' => '/mata-cms/carousel/carousel-item/process-video-url?carouselId='.$carouselItemModel->CarouselId.'&carouselItemId='.$carouselItemModel->Id,
        'formModel' => $formModel,
        'onComplete' => ""
        ]);
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

    $this->registerJs("
       $('#" . $form->id . "').on('beforeSubmit', function(event, jqXHR, settings) {
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
