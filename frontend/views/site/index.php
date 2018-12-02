<?php

use yii\helpers\Url;
use yii\web\JqueryAsset;

$this->registerJsFile('@web/js/likes.js', ['depends' => JqueryAsset::class]);
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>


    <div class="body-content">

        <div class="row">
            <h2>Все пользователи:</h2>
            <?php foreach ($users as $user): ?>
                <a href="<?php echo Url::to(['user/profile/view', 'id' => $user->id]); ?>">
                    <?php echo $user->username; ?> <br>
                </a>
            <?php endforeach ?>
            <hr>
        </div>

        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="row">
                <h2>Ваша лента новостей:</h2>
                <?php foreach ($feeds as $feed): ?>
                    <div class="col-md-6">
                        <p>
                            <a href="<?php echo Url::to(['user/profile/view', 'id' => $feed->user_id]); ?>">
                                <?php echo $feed->author_username; ?> <br>
                            </a>
                        </p>
                        <img src="<?php echo $feed->author_picture; ?>" alt="">
                        <p><?php echo $feed->post_description; ?></p>
                        <a href="<?php echo Url::to(['post/default/view', 'id' => $feed->post_id]); ?>">
                            <img src="<?php echo $feed->post_filename; ?>" alt="">
                        </a>
                        <p><?php echo Yii::$app->formatter->asDatetime($feed->post_created_at) ?></p>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <p>Только авторизованные пользователи могут ставить Лайки</p>
                        <?php endif; ?>

                        <button
                                id="like"
                                class="btn btn-primary"
                                data-id="<?php echo $feed->post_id; ?>"
                            <?php echo (($current_user && $current_user->likesPost($feed->post_id)) || Yii::$app->user->isGuest) ? 'disabled' : null ?>
                        >
                            Like
                        </button>
                        <button
                                id="unlike"
                                class="btn btn-primary"
                                data-id="<?php echo $feed->post_id; ?>"
                            <?php echo (($current_user && $current_user->likesPost($feed->post_id)) || Yii::$app->user->isGuest) ? null : 'disabled' ?>
                        >
                            Unlike
                        </button>

                        <p>Лайки: <span id="count_likes"><?php echo $feed->countLikes(); ?></span></p>
                    </div>
                <?php endforeach; ?>
                <hr>
            </div>
        <?php endif; ?>
    </div>
</div>
