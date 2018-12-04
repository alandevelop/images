<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $description
 * @property string $picture
 * @property int $created_at
 * @property int $complaints
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
            [['user_id', 'created_at', 'complaints'], 'integer'],
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
            'complaints' => 'Complaints',
        ];
    }

    public function approve()
    {
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);

        $this->complaints--;
        $this->save();
    }

    public function getPictureSrc()
    {
        return Yii::$app->params['storageUri'] . $this->picture;
    }
}
