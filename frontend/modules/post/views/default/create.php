<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

?>

<?php
$form = ActiveForm::begin();

echo $form->field($form_model, 'description');
echo $form->field($form_model, 'picture')->fileInput();

echo Html::submitButton('Создать пост');

ActiveForm::end();
?>