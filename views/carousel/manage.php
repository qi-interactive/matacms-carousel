<?php

use yii\helpers\Html;
use kartik\sortable\Sortable;
use yii\bootstrap\Modal;
use mata\media\helpers\MediaHelper;
use matacms\theme\simple\assets\ModuleUpdateAsset;
use matacms\widgets\ActiveForm;

$this->title = 'Update ' . $carouselModel->getModelLabel() . ': ' . ' ' . $carouselModel->getLabel();

/* @var $this yii\web\View */
/* @var $model mata\contentblock\models\ContentBlock */

ModuleUpdateAsset::register($this);


$this->params['breadcrumbs'][] = $this->title;

?>
<div class="carousel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        "id" => "form-room"
        ]);
    ?>

    <?= $form->field($carouselModel, 'Carousel')->carousel() ?>

    <?= \matacms\carousel\widgets\carousel\Carousel::widget([
            'carouselModel' => $carouselModel,
            'carouselItemsModel' => $carouselItemsModel,
            'name' => 'carousel'
        ]);
        ?>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->render('@vendor/matacms/matacms-base/views/module/_overlay'); ?>
<script>

	parent.mata.simpleTheme.header
	.setBackToListViewURL("<?= sprintf("/mata-cms/%s/%s", $this->context->module->id, $this->context->id) ?>")
	.showBackToListView()
	.show();

</script>
