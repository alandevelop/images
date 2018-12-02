<?php

namespace frontend\components;

use yii\base\Component;
use frontend\models\Feed;

class FeedService extends Component
{
    public function addToFeed($event)
    {
        $folowers = $event->user->getFollowers();
        $post = $event->post;

        foreach ($folowers as $folower) {
            $feed = new Feed();
            $feed->user_id = $folower['id'];
            $feed->author_id = $event->user->id;
            $feed->author_username = $event->user->username;
            $feed->author_picture = $event->user->picture;

            $feed->post_id = $post->id;
            $feed->post_filename = $post->picture;
            $feed->post_description = $post->description;
            $feed->post_created_at = $post->created_at;

            $feed->save();
        }
    }
}