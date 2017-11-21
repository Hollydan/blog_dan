<?php
/**
 * Created by PhpStorm.
 * User: Holly
 * Date: 2017/11/21
 * Time: 22:26
 */

namespace App\Handlers;


class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allow_ext = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

}