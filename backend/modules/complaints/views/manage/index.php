<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <?php if (Yii::$app->session->hasFlash('approve')): ?>
        <p>Пост одобрен!</p>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'description:ntext',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return "<img src='{$model->getPictureSrc()}' width='130px'>";
                }
            ],
            'created_at:datetime',
            'complaints',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {approve} {delete}',
                'buttons' => [
                    'approve' => function ($url, $model, $key) {
                        return '<a href="' . Url::to([
                                '/complaints/manage/approve',
                                'id' => $model->id
                            ]) . '" ><i class="glyphicon glyphicon-ok"></i></a>';
                    },
                ]
            ],
        ],
    ]); ?>
</div>
