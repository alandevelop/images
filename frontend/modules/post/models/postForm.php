<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 30.11.2018
 * Time: 14:12
 */

namespace frontend\modules\post\models;

use yii\base\Model;
use frontend\models\User;
use frontend\models\Post;
use frontend\components\Storage;
use Yii;
use frontend\modules\post\models\events\EventPostSave;
use Intervention\Image\ImageManager;

class PostForm extends Model
{
    const EVENT_POST_SAVE = 'event_post_save';

    public $description;
    public $picture;

    private $user;


    public function rules()
    {
        return [
            ['description', 'string', 'max' => 1000],
            [
                'picture',
                'file',
                'extensions' => ['png', 'jpg', 'gif'],
                'maxSize' => 1024 * 1024 * 2,
                'skipOnEmpty' => false,
            ]

        ];
    }

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->on(self::EVENT_POST_SAVE, [Yii::$app->feed, 'addToFeed']);
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'resizeImage']);
    }

    public function resizeImage()
    {
        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = $manager->make($this->picture->tempName);
        $image->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save();
    }

    public function save()
    {
        if ($this->validate()) {
            $post = new Post;
            $post->user_id = $this->user->id;
            $post->created_at = time();
            $post->description = $this->description;
            $post->picture = Storage::saveFile($this->picture, $this->user);
            if ($post->save()) {
                $event = new EventPostSave();
                $event->user = $this->user;
                $event->post = $post;
                $this->trigger(self::EVENT_POST_SAVE, $event);
                return true;
            }
        }
        return false;
    }
}