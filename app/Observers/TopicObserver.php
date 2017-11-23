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

    //进行save操作时生成摘要信息
    public function saving(Topic $topic)
    {
        $topic->excerpt = make_excerpt($topic->body);
    }
}