<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Поменять привилегии', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'about:ntext',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function ($model) {
                    return "<img src='{$model->getPictureSrc()}' width='200px'>";
                }
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {
                    return ($model->isAdmin()) ? 'Админ' : 'Пользователь';
                }
            ]
        ],
    ]) ?>

</div>


