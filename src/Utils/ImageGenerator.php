<?php

namespace WCIG\Utils;

defined('ABSPATH') || exit;

final class ImageGenerator {

    public static function string_to_image_b64($text) {
        $width = 150;
        $height = 40;
        $font_size = 5;

        $image = imagecreate($width, $height);

        $background_color = imagecolorallocate($image, 0, 0, 0);
        $text_color = imagecolorallocate($image, 255, 255, 255);

        $text_width = imagefontwidth($font_size) * strlen($text);
        $text_height = imagefontheight($font_size);
        $x = ($width - $text_width) / 2;
        $y = ($height - $text_height) / 2;

        imagestring($image, $font_size, $x, $y, $text, $text_color);

        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();

        imagedestroy($image);

        return sprintf('data:image/png;base64,%s', base64_encode($image_data));
    }

}