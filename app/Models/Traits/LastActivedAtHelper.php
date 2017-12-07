<?php
/**
 * Created by PhpStorm.
 * User: Holly
 * Date: 2017/12/6
 * Time: 22:46
 */

namespace App\Models\Traits;


use Carbon\Carbon;
use Redis;

trait LastActivedAtHelper
{
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    /**
     * 最后登录时间存到 redis中
     */
    public function recordLastActivedAt()
    {
        //获取当天日期
        $date = Carbon::now()->toDateString();

        //redis 哈希表的命名
        $hash = $this->getHashFromDateString($date);

        //字段名称
        $field = $this->getHashField();

        //当前时间
        $now = Carbon::now()->toDateTimeString();

        //数据写入 redis ，数据已存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * redis 数据同步到数据库中
     */
    public function syncUserActivedAt()
    {
        //获取昨天日期
        $yestoday_date = Carbon::now()->subDay()->toDateString();

        // redis 哈希表名称
        $hash = $this->getHashFromDateString($date);

        // redis 中获取所有表中的数据
        $dates = Redis::hGetAll($hash);

        //将数据同步到数据库
        foreach ($dates as $user_id => $actived_at) {

            //截取用户 ID
            $user_id = str_replace($this->field_prefix, '', $user_id);

            //当用户存在时，才同步
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        //同步到数据库后，删除 redis 中的数据
        Redis::del($hash);
    }

    /**
     * 读取用户最后登录时间
     *
     * @param $value
     * @return Carbon
     */
    public function getLastActivedAtAttribute($value)
    {
        //获取今天日期
        $date = Carbon::now()->toDateString();

        $hash = $this->getHashFromDateString($date);

        $field = $this->getHashField();

        $datetime = Redis::hGet($hash, $field) ? : $value;

        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }
    }

    /**
     * redis 哈希表命名
     *
     * @param $date
     * @return string
     */
    public function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    /**
     * 哈希表的字段名称
     *
     * @return string
     */
    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}