<?php

use yii\helpers\Html;
use matacms\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model matacms\carousel\models\Carousel */
/* @var $form ActiveForm */

?>
<div class="carousel">

    <?php $form = ActiveForm::begin([
        "id" => "form-carousel"
        ]); 
    ?>

        <?= $form->field($model, 'Title') ?>
        <?= $form->field($model, 'Region') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div><!-- qwdqwd -->
