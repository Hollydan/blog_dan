<?php
/**
 * Created by PhpStorm.
 * User: Holly
 * Date: 2017/11/21
 * Time: 22:26
 */

namespace App\Handlers;


use function foo\func;
use Intervention\Image\Image;

class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allow_ext = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        //存储的文件夹规则
        $folder_name = 'uploads/images/' . $folder . '/' . date('Ym', time()) . '/' . date('d', time()) . '/';

        //图片存储的物理路径
        $upload_path = public_path() . '/' . $folder_name;

        //获取文件后缀，因图片从剪切板里粘贴时后缀名为空，所以此处确保后缀名一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ? : 'png';

        //拼接文件名，前缀可以使相关数据模型的 ID
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' .$extension;

        //如果上传的不是图片将终止操作
        if (! in_array($extension, $this->allow_ext)) {
            return false;
        }

        //将图片移动到目标存储路径
        $file->move($upload_path, $filename);

        //如果限制了图片宽度，进行裁剪
        if ($max_width && $extension != 'gif') {

            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . '/' . $folder_name . '/' . $filename,
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        //先实例化，参数为文件的磁盘物理路径
        $image = Image::make($file_path);

        //进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            //设定宽度为$max_width，高度等比例缩放
            $constraint->aspectRatio();

            //防止截图时图片尺寸变大
            $constraint->upsize();
        });

        //保存修改的图片
        $image->save();
    }

}