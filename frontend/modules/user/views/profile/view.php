<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 25.11.2018
 * Time: 12:11
 */

//use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile('@web/js/upload-avatar.js',
    ['depends' => ['frontend\assets\AppAsset', 'yii\bootstrap\BootstrapPluginAsset']]);
?>
<?php
echo 'Профайл пользователя ' . Html::encode($user->username) . '</br>';
echo 'Информация о пользователе ' . Html::encode($user->about) . '</br>';
?>
    <hr>

<?php if ($currentUser !== null && $currentUser->equals($user)): ?>
    <input type="file" name="uploadAvatar" id="uploadAvatar"
           data-url="<?php echo Url::to(['/user/profile/upload-avatar']); ?>">
    <div class="avatarErrors" style="display: none;"></div>
<?php endif; ?>

    <img src="<?php echo $user->getAvatar(); ?>" id="avatarImg">
    <hr>


<?php if ($currentUser !== null && !$currentUser->equals($user)): ?>

    <?php if ($currentUser->isSubscribedTo($user)): ?>
        <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->id]) ?>">Отписаться от
            пользователя <?php echo Html::encode($user->username) ?></a>
    <?php else: ?>
        <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->id]) ?>">Подписаться на
            пользователя <?php echo Html::encode($user->username) ?></a>
    <?php endif; ?>

    <hr>
<?php endif; ?>


    <p>Подписчики пользователя <?php echo Html::encode($user->username) ?>:</p>
<?php foreach ($user->getFollowers() as $item): ?>
    <a href="<?php echo Url::to(['/user/profile/view', 'id' => $item['id']]) ?>"><?php echo $item['username'] ?></a><br>
<?php endforeach; ?>


    <hr>

    <p>Подписки пользователя <?php echo Html::encode($user->username) ?>:</p>
<?php foreach ($user->getSubscriptions() as $item): ?>
    <a href="<?php echo Url::to(['/user/profile/view', 'id' => $item['id']]) ?>"><?php echo $item['username'] ?></a><br>
<?php endforeach; ?>