<?php

namespace App\Helpers;

class ImageHelper
{
    public static function resizeImage($fullPath, $path, $width, $height = null)
    {
        list($originalWidth, $originalHeight) = getimagesize($fullPath);

        // 高さが指定されていない場合は、アスペクト比を維持して高さを計算
        if ($height === null) {
            $height = intval(($originalHeight / $originalWidth) * $width);
        }

        // 画像のリサイズ
        $src = imagecreatefromstring(file_get_contents($fullPath));
        $dst = imagecreatetruecolor($width, $height);

        // GDライブラリを使用して画像をリサイズするための関数
        // 元の画像から新しい画像へのサンプリングとリサイズ
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

        // リサイズされた画像を保存
        imagejpeg($dst, $fullPath);

        // メモリを解放
        imagedestroy($src);
        imagedestroy($dst);
    }
}
