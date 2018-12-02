<?php

use yii\web\JqueryAsset;

$this->registerJsFile('@web/js/likes.js', ['depends' => JqueryAsset::class]);
?>

<p>Автор поста: <?php echo $user->username ?></p>
<p>Описание поста: <?php echo $post->description ?></p>
<img src="<?php echo $post->picture ?>" alt="">

<hr>

<?php if (Yii::$app->user->isGuest): ?>
    <p>Только авторизованные пользователи могут ставить Лайки</p>
<?php endif; ?>

<button
        class="btn btn-primary like"
        data-id="<?php echo $post->id; ?>"
    <?php echo ($current_user && $post->isLikedBy($current_user->id)) ? 'disabled' : null ?>
>
    Like
</button>
<button
        class="btn btn-primary unlike"
        data-id="<?php echo $post->id; ?>"
    <?php echo ($current_user && $post->isLikedBy($current_user->id)) ? null : 'disabled' ?>
>
    Unlike
</button>

<p>Лайки: <span class="count_likes"><?php echo $post->countLikes(); ?></span></p>
