<?php

namespace frontend\modules\user\models;

use yii\base\Model;


class AvatarForm extends Model
{
    public $picture;

    public function rules()
    {
        return [
            ['picture', 'file', 'extensions' => ['png', 'jpg', 'gif']]
        ];
    }
}
