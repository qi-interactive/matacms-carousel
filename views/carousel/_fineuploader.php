<?php
use yii\helpers\Html;
use yii\web\View;

?>

<div id="<?= $widget->id ?>" class="file-uploader">


	<?php 

	$this->registerJs("
		$(document).ready(function() {

			var manualuploader = $('" . $widget->selector . " .fine-uploader').fineUploaderS3({
				request: {
					endpoint: 'https://s3-eu-west-1.amazonaws.com/" .  $widget->s3Bucket . "',
					accessKey: '" .  $widget->s3Key . "',
				},
				objectProperties: {
					acl: 'public-read',
					key: function(fileId) {
						var filename = $('" . $widget->selector ." .fine-uploader').fineUploaderS3('getName', fileId);
						return '" . $widget->s3Folder . "/' + filename;
					}
				},
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
				template: 'qq-simple-thumbnails-template',
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

			}).on('submit', function() {
				$('" . $widget->selector . " .current-media').remove();
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
	<?php echo Html::img($mediaModel->URI, array(
		"style" => "width: 100px",
		"class" => "current-media"
		)); ?>
	<?php endif; ?>
	<div class="fine-uploader"></div>

</div>
<!-- Fine Uploader template
	====================================================================== -->

	<script type="text/template" id="qq-simple-thumbnails-template">
		<div class="qq-uploader-selector qq-uploader">


			<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
				<span>Drop files here to upload</span>
			</div>
			<div class="qq-upload-button-selector qq-upload-button">
				<div>Upload a file</div>
			</div>
			<span class="qq-drop-processing-selector qq-drop-processing">
				<span>Processing dropped files...</span>
				<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
			</span>
			<ul class="qq-upload-list-selector qq-upload-list">
				<li></li>
			</ul>
		</div>
	</script>