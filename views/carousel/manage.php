<?php

use yii\helpers\Html;
use kartik\sortable\Sortable;
use yii\bootstrap\Modal;
use mata\media\helpers\MediaHelper;
use matacms\theme\simple\assets\ModuleUpdateAsset;

$this->title = 'Update ' . $carouselModel->getModelLabel() . ': ' . ' ' . $carouselModel->getLabel();

/* @var $this yii\web\View */
/* @var $model mata\contentblock\models\ContentBlock */

ModuleUpdateAsset::register($this);


$this->params['breadcrumbs'][] = $this->title;

?>
<div class="carousel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \matacms\carousel\widgets\carousel\Carousel::widget([
            'carouselModel' => $carouselModel,
            'carouselItemsModel' => $carouselItemsModel,
            'name' => 'carousel'
        ]);
        ?>

</div>

<<<<<<< HEAD
=======
<?= $this->render('@vendor/matacms/matacms-base/views/module/_overlay'); ?>

>>>>>>> ce59539f46be708e4471ced62f47a5d0998e4a82
<script>

	parent.mata.simpleTheme.header
	.setBackToListViewURL("<?= sprintf("/mata-cms/%s/%s", $this->context->module->id, $this->context->id) ?>")
	.showBackToListView()
<<<<<<< HEAD
=======
	.setVersionsURL('<?= sprintf("/mata-cms/%s/%s/history?documentId=%s&returnURI=%s", $this->context->module->id, $this->context->id, urlencode($carouselModel->getDocumentId()->getId()), Yii::$app->request->url) ?>')
	.showVersions()
>>>>>>> ce59539f46be708e4471ced62f47a5d0998e4a82
	.show();

</script>

