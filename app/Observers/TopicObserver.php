<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
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
        //进行 save 操作时生成摘要信息
        $topic->excerpt = make_excerpt($topic->body);

        //对文章内容 xss 过滤
        $topic->body = clean($topic->body, 'user_topic_body');
    }

    public function saved(Topic $topic)
    {
        //如果 slug 没有内容，使用翻译器对 title 进行翻译
        if (! $topic->slug) {
            //推送任务到队列中
            dispatch(new TranslateSlug($topic));
        }
    }

    //删除话题时，连带删除话题的评论
    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}