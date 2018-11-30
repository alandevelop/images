<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 30.11.2018
 * Time: 14:56
 *
 */

namespace frontend\components;

use yii\web\UploadedFile;
use frontend\models\User;
use yii\helpers\FileHelper;

class Storage
{
    public static function saveFile(UploadedFile $file, User $user)
    {
        $new_name = sha1_file($file->tempName) . '.' . $file->extension;
        $path = 'uploads/' . $user->id . '/' . $new_name;
        FileHelper::createDirectory(dirname($path));

        if ($file->saveAs($path)) {
            return '/' . $path;
        } else {
            throw new ServerErrorHttpException();
        }
    }

    public static function removeFile($path)
    {
        $path = substr_replace($path, '', 0, 1);
        FileHelper::unlink($path);
    }
}