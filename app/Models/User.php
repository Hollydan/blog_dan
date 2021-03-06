<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    //活跃用户
    use Traits\ActiveUserHelper;
    //用户最后登录时间
    use Traits\LastActivedAtHelper;
    use HasRoles;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //判断用户权限
    public function isAuthorOf($model)
    {
        return $model->user_id == $this->id;
    }

    //通知状态设定为已读
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications();
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        //如果提交的密码为空，不作处理
        if (is_null($value) || empty($value)) return;

        if (strlen($value) != 60) {
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    /**
     * @param $path
     */
    public function setAvatarAttribute($path)
    {
        //如果不是 http 开头，需要不全图片路径
        if (! starts_with($path, 'http')) {
            $path = config('app.url') . '/uploads/images/avatars/' . $path;
        }

        $this->attributes['avatar'] = $path;
    }
}
