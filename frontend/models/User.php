<?php
namespace frontend\models;

use Faker\Provider\File;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use frontend\components\Storage;
use frontend\models\Post;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $about
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['about', 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUserEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }

    public function subscribe($user)
    {
        $redis = Yii::$app->redis;

        $redis->sadd("user:{$this->id}:subscriptions", $user->id);
        $redis->sadd("user:{$user->id}:followers", $this->id);
    }

    public function unsubscribe($user)
    {
        $redis = Yii::$app->redis;

        $redis->srem("user:{$this->id}:subscriptions", $user->id);
        $redis->srem("user:{$user->id}:followers", $this->id);
    }

    public function getSubscriptions()
    {
        $redis = Yii::$app->redis;
        $ids = $redis->smembers("user:{$this->id}:subscriptions");

        return User::find()->where(['id' => $ids])->orderBy('username')->all();
    }

    public function getFollowers()
    {
        $redis = Yii::$app->redis;
        $ids = $redis->smembers("user:{$this->id}:followers");

        return User::find()->where(['id' => $ids])->orderBy('username')->all();
    }

    public function isSubscribedTo($user)
    {
        $redis = Yii::$app->redis;
        return $redis->sismember("user:{$this->id}:subscriptions", $user->id);
    }

    public function saveAvatarFile(UploadedFile $file)
    {
        $path = Storage::saveFile($file, $this);
        if ($this->picture) {
            Storage::removeFile($this->picture);
        }
        $this->picture = $path;

        $this->save(false);
    }

    public function getAvatar()
    {
        return $this->picture ? $this->picture : '/img/no-image.png';
    }

    public function getFeeds()
    {
        return $this->hasMany(Feed::class, ['user_id' => "id"])->all();
    }

    public function likesPost($post_id)
    {
        $redis = Yii::$app->redis;
        return $redis->sismember("user:{$this->id}:likes", $post_id);
    }

    public function isAdmin()
    {
        if (Yii::$app->authManager->getAssignment('admin', $this->id)) {
            return true;
        }

        return false;
    }
}
