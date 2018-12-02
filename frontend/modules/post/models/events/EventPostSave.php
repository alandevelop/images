<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 02.12.2018
 * Time: 17:32
 */

namespace frontend\modules\post\models\events;

use yii\base\Event;


class EventPostSave extends Event
{
    public $user;
    public $post;

    public function getUser()
    {
        return $this->user;
    }

    public function getPost()
    {
        return $this->post;
    }
}