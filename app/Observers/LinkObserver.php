<?php
/**
 * Created by PhpStorm.
 * User: bc-033
 * Date: 17-12-6
 * Time: 下午6:56
 */

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }

}