<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $description
 * @property string $picture
 * @property int $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'picture', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['picture'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'description' => 'Description',
            'picture' => 'Picture',
            'created_at' => 'Created At',
        ];
    }

    public function like($user_id)
    {
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->id}:likes", "$user_id");
        $redis->sadd("user:{$user_id}:likes", $this->id);
    }

    public function unlike($user_id)
    {
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->id}:likes", "$user_id");
        $redis->srem("user:{$user_id}:likes", $this->id);
    }

    public function countLikes()
    {
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->id}:likes");
    }

    public function isLikedBy($user_id)
    {
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->id}:likes", $user_id);
    }

}
