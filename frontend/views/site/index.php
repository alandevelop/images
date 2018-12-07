<?php

use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\helpers\Html;

$this->registerJsFile('@web/js/likes.js', ['depends' => JqueryAsset::class]);
$this->registerJsFile('@web/js/complaints.js', ['depends' => JqueryAsset::class]);
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-4">
                <h3>Все пользователи:</h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php foreach ($users as $user) : ?>
                            <a href="<?php echo Url::to(['user/profile/view', 'id' => $user->id]); ?>"
                               class='list_link'>
                                <span class="list_avatar"
                                      style="background-image: url(<?php echo $user->getAvatar() ?>);"></span>
                                <span class="list_name"><?php echo $user->username; ?></span>
                            </a>
                        <?php endforeach ?>
                    </div>
                </div>


            </div>

            <div class="col-md-8">
                <h3>Ваша лента новостей</h3>

                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?php foreach ($feeds as $feed): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <a href="<?php echo Url::to(['user/profile/view', 'id' => $feed->author_id]); ?>"
                                   class='list_link pull-left'>
                                    <span class="list_avatar"
                                          style="background-image: url(<?php echo $feed->author_picture; ?>);"></span>
                                    <span class="list_name"><?php echo $feed->author_username; ?></span>
                                </a>
                                <span class="pull-right"
                                      style="line-height: 40px;"><?php echo Yii::$app->formatter->asDatetime($feed->post_created_at) ?></span>
                            </div>
                            <div class="panel-body">
                                <a href="<?php echo Url::to(['post/default/view', 'id' => $feed->post_id]); ?>">
                                    <img src="<?php echo Html::encode($feed->post_filename); ?>" class="img-responsive">
                                </a>
                                <p style="margin-top: 20px;"><?php echo $feed->post_description; ?></p>
                            </div>
                            <div class="panel-footer">
                                <div class="btn-group">
                                    <button class="btn btn-primary like" data-id="<?php echo $feed->post_id; ?>"
                                        <?php echo (($current_user && $current_user->likesPost($feed->post_id)) || Yii::$app->user->isGuest) ? 'disabled' : null ?>
                                    >Like
                                    </button>

                                    <button class="btn btn-primary unlike" data-id="<?php echo $feed->post_id; ?>"
                                        <?php echo (($current_user && $current_user->likesPost($feed->post_id)) || Yii::$app->user->isGuest) ? null : 'disabled' ?>
                                    >Unlike
                                    </button>

                                    <button class="count_likes btn btn-default"
                                            disabled="disabled"><?php echo $feed->countLikes(); ?></button>
                                </div>
                                <button
                                        class="btn btn-warning complain pull-right"
                                        data-id="<?php echo $feed->post_id; ?>"
                                    <?php echo ($feed->isComplainedBy($current_user)) ? 'disabled' : null ?>
                                >
                                    <?php echo ($feed->isComplainedBy($current_user)) ? 'Жалоба подана' : 'Пожаловаться на пост' ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Войдите чтобы просматривать вашу ленту новостей</p>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>
