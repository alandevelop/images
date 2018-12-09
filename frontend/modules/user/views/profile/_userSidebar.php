<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Html::encode($user->username) ?></h3>
    </div>
    <div class="panel-body">
        <p><?php echo 'Информация о пользователе:'; ?></p>

        <div class="descr_text">
            <p><?php echo Html::encode($user->about); ?></p>
            <?php if ($currentUser !== null && $currentUser->equals($user)) : ?>
                <a href="#" class="btn btn-default btn-block descr_change" style="margin-bottom: 20px;">Изменить
                    описание</a>
            <?php endif; ?>
        </div>

        <?php if ($currentUser !== null && $currentUser->equals($user)) : ?>
            <form role="form" class="descr_form" style="display: none;">
                <div class="form-group">
                    <textarea class="form-control descr_textarea" rows="10"
                              data-id="<?php echo $currentUser->id ?>"><?php echo Html::encode($user->about); ?></textarea>
                </div>
                <button class="btn btn-default btn-block descr_cancel">Отмена</button>
                <button type="submit" class="btn btn-success btn-block descr_submit">Сохранить</button>
            </form>
        <?php endif; ?>

        <hr>

        <span class="bigAvatar" style="background-image: url(<?php echo $user->getAvatar(); ?>);" id="avatarImg"></span>

        <?php if ($currentUser !== null && $currentUser->equals($user)) : ?>
            <label class="btn btn-default btn-block" style="margin-top: 20px;">
                <input type="file" style="display: none;" name="uploadAvatar" id="uploadAvatar"
                       data-url="<?php echo Url::to(['/user/profile/upload-avatar']); ?>"/>
                Поменять аватар
            </label>
            <div class="avatarErrors" style="display: none;"></div>

            <hr>
            <a href="<?php echo Url::to(['/user/profile/delete', 'id' => $currentUser->id]); ?>"
               class="btn btn-danger btn-block" onclick="return confirm('Вы уверены?')"
               style="margin-top: 20px;"
            >Удалить свой профиль</a>
        <?php endif; ?>
        <hr>


        <?php if ($currentUser !== null && !$currentUser->equals($user)) : ?>
            <?php if ($currentUser->isSubscribedTo($user)) : ?>
                <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->id]) ?>"
                   class="btn btn-primary center-block btn-sm">
                    Отписаться от <?php echo Html::encode($user->username) ?></a>
            <?php else : ?>
                <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->id]) ?>"
                   class="btn btn-primary center-block btn-sm">
                    Подписаться на <?php echo Html::encode($user->username) ?></a>
            <?php endif; ?>

            <hr>
        <?php endif; ?>


        <p>Подписчики пользователя <?php echo Html::encode($user->username) ?>:</p>
        <?php foreach ($user->getFollowers() as $item) : ?>
            <a href="<?php echo Url::to(['/user/profile/view', 'id' => $item->id]); ?>" class='list_link'>
                <span class="list_avatar" style="background-image: url(<?php echo $item->getAvatar() ?>);"></span>
                <span class="list_name"><?php echo $item->username; ?></span>
            </a>
        <?php endforeach; ?>
        <hr>

        <p>Подписки пользователя <?php echo Html::encode($user->username) ?>:</p>
        <?php foreach ($user->getSubscriptions() as $item) : ?>
            <a href="<?php echo Url::to(['/user/profile/view', 'id' => $item->id]); ?>" class='list_link'>
                <span class="list_avatar" style="background-image: url(<?php echo $item->getAvatar() ?>);"></span>
                <span class="list_name"><?php echo $item->username; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>