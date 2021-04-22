<?php
function priceFormat($number)
{
    $decimal_point = '.';
    $thousand_point = ' ';
    $symbol_left = '';
    $symbol_right = ' pуб.';
    $decimal_place = 0;

    $string = '';

    if ($symbol_left) {
        $string .= $symbol_left;
    }

    $string .= number_format(round((float)$number, (int)$decimal_place), (int)$decimal_place, $decimal_point, $thousand_point);

    if ($symbol_right) {
        $string .= $symbol_right;
    }

    return $string;
}

function resize($filename, $width, $height, $type = "")
{
    require_once DIR_HELPERS . 'utf8.php';

    if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
        $filename = "noimage.jpg";
    }

    $info = pathinfo($filename);

    $extension = $info['extension'];

    $old_image = $filename;
    $new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type . '.' . $extension;

    if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
        $path = '';

        $directories = explode('/', dirname(str_replace('../', '', $new_image)));

        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;

            if (!file_exists(DIR_IMAGE . $path)) {
                @mkdir(DIR_IMAGE . $path, 0777);
            }
        }

        list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

        if ($width_orig != $width || $height_orig != $height) {
            $image = new app\lib\Image(DIR_IMAGE . $old_image);
            $image->resize($width, $height, $type);
            $image->save(DIR_IMAGE . $new_image);
        } else {
            copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
        }
    }

    return $new_image;
}