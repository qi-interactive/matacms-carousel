<?php

use matacms\widgets\ActiveForm;

?>

<div class="carousel">

    <?php $form = ActiveForm::begin([
        "id" => "form-carousel"
        ]);
    ?>

        <?= $form->field($model, 'Title') ?>

		<?= $form->field($model, 'Region') ?>

        <?= $form->field($model, 'IsDraft')->checkbox(['label'=>'<div></div><span class="checkbox-label">'.$model->getAttributeLabel('IsDraft'). '</span>']) ?>

        <?= $form->submitButton($model) ?>

    <?php ActiveForm::end(); ?>

</div>
