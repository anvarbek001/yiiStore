<?php

namespace common\components;

use Yii;
use yii\web\UploadedFile;

class FileUploader
{
    /**
     * Rasmni yuklash
     * @param UploadedFile $file
     * @param string $folder
     * @return string|false filename yoki false
     */
    public static function upload($file, $folder = 'products')
    {
        if (!$file) {
            return false;
        }

        // Papka yaratish
        $uploadPath = Yii::getAlias('@uploads') . '/' . $folder;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Unique fayl nomi
        $fileName = uniqid() . '.' . $file->extension;
        $filePath = $uploadPath . '/' . $fileName;

        // Saqlash
        if ($file->saveAs($filePath)) {
            return $folder . '/' . $fileName;
        }

        return false;
    }

    /**
     * Rasmni o'chirish
     * @param string $imagePath
     * @return bool
     */
    public static function delete($imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }

        $fullPath = Yii::getAlias('@uploads') . '/' . $imagePath;

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }

    /**
     * Rasm URL ini olish
     * @param string $imagePath
     * @return string
     */
    public static function getUrl($imagePath)
    {
        if (empty($imagePath)) {
            return '/images/no-image.png';
        }

        return '/uploads/' . $imagePath;
    }
}
