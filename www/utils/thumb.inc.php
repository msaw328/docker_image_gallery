<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/config.inc.php');

    function thumb_create($image_path) {
        list($w, $h, $type) = getimagesize($image_path);
        switch($type) {
            case IMAGETYPE_GIF: $img = imagecreatefromgif($image_path); break;
            case IMAGETYPE_PNG: $img = imagecreatefrompng($image_path); break;
            case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($image_path); break;
            default: break;
        }

        if($w > $h) {
            $src_height = $h;
            $src_width = $h;
            $src_y = 0;
            $src_x = ($w - $h) / 2;
        } else {
            $src_height = $w;
            $src_width = $w;
            $src_y = ($h - $w) / 2;
            $src_x = 0;
        }

        $thumb = imagecreatetruecolor(APP_THUMB_WIDTH, APP_THUMB_HEIGHT);

        // preserve transparency
        if($type === IMAGETYPE_GIF or $type === IMAGETYPE_PNG){
            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }

        $res = imagecopyresampled(
            $thumb, $img,                       // dst_img, src_img
            0, 0,                               // dst_x,y
            $src_x, $src_y,                     // src_x,y
            APP_THUMB_WIDTH, APP_THUMB_HEIGHT,  // dst_width,height
            $src_width, $src_height             // src_width,height
        );
        
        ob_start();
        switch($type) {
            case IMAGETYPE_GIF: imagegif($thumb); break;
            case IMAGETYPE_PNG: imagepng($thumb); break;
            case IMAGETYPE_JPEG: imagejpeg($thumb); break;
            default: break;
        }

        $contents = ob_get_clean();
        return $contents;
    }
?>
