<?php

use yii\helpers\Html;
use kartik\sortable\Sortable;
use yii\bootstrap\Modal;
use mata\media\helpers\MediaHelper;

/* @var $this yii\web\View */
/* @var $model mata\contentblock\models\ContentBlock */

$this->title = $carouselModel->Title;
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
