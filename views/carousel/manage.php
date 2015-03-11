<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model mata\contentblock\models\ContentBlock */

$this->title = $carouselModel->Title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $carouselItems,
        'attributes' => [
            'Id',
            'Caption:ntext'
        ],
    ]) ?>

</div>
