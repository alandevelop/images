<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="user-index">

    <h1>Пользователи</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function ($model) {
                    return "<img src='{$model->getPictureSrc()}' width='70px'>";
                }
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {
                    return ($model->isAdmin()) ? 'Админ' : 'пользователь';
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>


