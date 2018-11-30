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

class PostForm extends Model
{
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
    }

    public function save()
    {
        if ($this->validate()) {
            $post = new Post;
            $post->user_id = $this->user->id;
            $post->created_at = time();
            $post->description = $this->description;
            $post->picture = Storage::saveFile($this->picture, $this->user);
            $post->save();
        }
    }
}