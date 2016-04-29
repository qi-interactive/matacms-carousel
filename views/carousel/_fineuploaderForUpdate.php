<?php
use yii\helpers\Html;
use yii\web\View;

?>

<div id="<?= $widget->id ?>" class="file-uploader">


	<?php

	$templateId = 'qq-simple-thumbnails-template-'.$widget->id;

	$this->registerJs("
		$(document).ready(function() {

			var carouselManualUploader = $('" . $widget->selector . " .fine-uploader').fineUploaderS3({
				request: {
					endpoint: 'https://s3-eu-west-1.amazonaws.com/" .  $widget->s3Bucket . "',
					accessKey: '" .  $widget->s3Key . "',
				},
				objectProperties: {
					acl: 'public-read',
					key: function(fileId) {
						var keyRetrieval = new qq.Promise(),
						filename = $('" . $widget->selector ." .fine-uploader').fineUploaderS3('getName', fileId);

						$.ajax({
							type: 'POST',
							url: '/mata-cms/media/s3/set-random-file-name',
							data: {name: filename},
							success: function(data) {
								var result = '" . $widget->s3Folder . "/' + data.key;
								keyRetrieval.success(result);
							},
							error: function() { keyRetrieval.failure(); },
							dataType: 'json'
						});

return keyRetrieval;
}
},
multiple: " . ($widget->options['multiple'] ? 'true' : 'false') . ",
			// Move to module settings
validation: {
	allowedExtensions: ['jpg', 'jpeg', 'gif', 'png', 'pdf', 'ico'],
	sizeLimit: 2000000
},
signature: {
	customHeaders: {'X-CSRF-Token':'" . \Yii::$app->request->getCsrfToken() . "'},
	endpoint: '/mata-cms/media/s3/signature'
},
showMessage: function(message) {
	if (message != 'No files to upload.') {
		alert(message);
	} else {
		if(uploadsPending == 0)
			form.submit();
	}
},
uploadSuccess: {
	customHeaders: {'X-CSRF-Token':'" . \Yii::$app->request->getCsrfToken() . "'},
	endpoint: '".$widget->uploadSuccessEndpoint."'
},
template: '$templateId',
listElement: false,
autoUpload: true,
}).on('allComplete', function() {
			// setTimeout(function() {
			// 	if(uploadsPending == 0)
			// 		form.submit();
			// 	// form.submit();
			// }, 800)
}).on('complete', function(a, id, name, uploadSuccessResponse, t, c) {
	if (uploadSuccessResponse.Id == null) {
		alert('Media Upload failed. Please get in touch with your support team.');
	}
	" . $widget->events['complete'] . "
	$('" . $widget->selector . " .current-media').attr('src', uploadSuccessResponse.URI);
	$('.qq-upload-spinner').css('opacity', 0);
}).on('progress', function(event, id, fileName, loaded, total) {
	$('" . $widget->selector . " .qq-upload-spinner').css({
		'opacity': 1,
		width : ((loaded/total)*100) + '%'
	});

if($('" . $widget->selector . " .qq-upload-spinner')[0].style.width == '100%')
	$('" . $widget->selector . " .qq-upload-spinner').addClass('success');

}).on('submit', function() {
	$('" . $widget->selector . " .qq-upload-success').remove();
});

		// form.on('submit.manualUploader', function() {
		// 	$('#" .  $widget->selector . " #current-media').remove();
		// 	manualuploader.fineUploader('uploadStoredFiles');
		// 	form.off('submit.manualUploader');
		// 	return false;
		// })
});", View::POS_READY);

?>


<!-- Fine Uploader DOM Element
	====================================================================== -->
	<?php
	if ($mediaModel): ?>
	<div class="img-container">
		<?php echo Html::img($mediaModel->URI, array(
			// "style" => "width: 100px",
			"class" => "current-media"
			)); ?>
		</div>
	<?php endif; ?>
	<div class="fine-uploader"></div>

<!-- Fine Uploader template
	====================================================================== -->

	<script type="text/template" id="<?= $templateId ?>">
		<div class="qq-uploader-selector qq-uploader">

			<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
				<span>Drop files here to upload</span>
			</div>
			<div class="qq-upload-button-selector qq-upload-button">
				<div class="add-media-inner-wrapper">
					<div class="hi-icon-effect-2">
						<div class="hi-icon hi-icon-cog">
						</div>
					</div>
					<span> CLICK or DRAG & DROP </br> to upload a file</span>
				</div>
				<span class="qq-drop-processing-selector qq-drop-processing">
					<span>Processing dropped files...</span>
					<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
				</span>
				<ul class="qq-upload-list-selector qq-upload-list">
					<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
					<li></li>
				</ul>
			</div>
		</script>
