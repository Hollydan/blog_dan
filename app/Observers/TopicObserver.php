<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        //进行save操作时生成摘要信息
        $topic->excerpt = make_excerpt($topic->body);

        //对文章内容xss过滤
        $topic->body = clean($topic->body, 'user_topic_body');
    }
}