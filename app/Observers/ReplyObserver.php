<?php

namespace App\Observers;

use App\Models\Reply;
use App\Models\Topic;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function created(Reply $reply)
    {
        $topic = $reply->topic;

        $topic->increment('reply_count', 1);

        //如果评论的作者不是话题作者，则推送通知消息
        if (! $reply->user->isAuthorOf($topic)) {
            $topic->user->notify(new TopicReplied($reply));
        }
    }
}