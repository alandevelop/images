<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>


<?php
$form = ActiveForm::begin();

echo $form->field($formModel, 'description');
echo $form->field($formModel, 'picture')->fileInput();

echo Html::submitButton('Создать пост');

ActiveForm::end();
?>