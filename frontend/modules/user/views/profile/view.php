<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 25.11.2018
 * Time: 12:11
 */

use yii\helpers\Html;
use yii\web\JqueryAsset;

$this->registerJsFile('@web/js/upload-avatar.js',
    ['depends' => ['frontend\assets\AppAsset', 'yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('@web/js/likes.js', ['depends' => JqueryAsset::class]);
$this->registerJsFile('@web/js/complaints.js', ['depends' => JqueryAsset::class]);
$this->registerJsFile('@web/js/changeDescription.js', ['depends' => JqueryAsset::class]);
$this->registerJsFile('@web/js/deletePost.js', ['depends' => JqueryAsset::class]);
?>

<div class="col-md-4">
    <?php echo $this->render('_userSidebar', [
        'currentUser' => $currentUser,
        'user' => $user,
    ]); ?>
</div>

<div class="col-md-8">
    <div class="row">
        <?php foreach ($user->posts as $post) : ?>
            <div class="col-md-12 postItem">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="<?php echo Html::encode($post->picture); ?>" class="img-responsive">
                        <p style="margin-top: 20px;"><?php echo $post->description; ?></p>
                    </div>
                    <?php if ($currentUser && !$currentUser->equals($user)) : ?>
                        <div class="panel-footer">
                            <div class="btn-group">
                                <button class="btn btn-primary like" data-id="<?php echo $post->id; ?>"
                                    <?php echo (($currentUser && $currentUser->likesPost($post->id)) || Yii::$app->user->isGuest) ? 'disabled' : null ?>
                                >Like
                                </button>

                                <button class="btn btn-primary unlike" data-id="<?php echo $post->id; ?>"
                                    <?php echo (($currentUser && $currentUser->likesPost($post->id)) || Yii::$app->user->isGuest) ? null : 'disabled' ?>
                                >Unlike
                                </button>

                                <button class="count_likes btn btn-default"
                                        disabled="disabled"><?php echo $post->countLikes(); ?></button>
                            </div>

                            <button
                                    class="btn btn-warning complain pull-right"
                                    data-id="<?php echo $post->id; ?>"
                                <?php echo ($post->isComplainedBy($currentUser)) ? 'disabled' : null ?>
                                    style="margin-left: 15px;"
                            >
                                <?php echo ($post->isComplainedBy($currentUser)) ? 'Жалоба подана' : 'Пожаловаться на пост' ?>
                            </button>

                            <span class="pull-right" style="line-height: 40px;">
                                <?php echo Yii::$app->formatter->asDatetime($post->created_at) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ($currentUser && $currentUser->equals($user)) : ?>
                        <div class="panel-footer clearfix">
                            <a href='#'
                               class="btn btn-danger pull-right deleteBtn"
                               data-id="<?php echo $post->id; ?>"
                               style="margin-left: 15px;"
                            >
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                            <span class="pull-right" style="line-height: 40px;">
                                <?php echo Yii::$app->formatter->asDatetime($post->created_at) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



