<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/image.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/thumb.inc.php');

    class ImageController {
        static function upload($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /index.php');
                die();
            }

            if(!isset($req['title']) || !isset($files['image_file'])) {
                header('Location: /index.php');
                die();
            }
            $image_file = $files['image_file'];

            if($image_file['error'] !== UPLOAD_ERR_OK) {
                header('Location: /index.php');
                die();
            }

            if(!is_uploaded_file($image_file['tmp_name'])) {
                header('Location: /index.php');
                die();
            }

            $info = getimagesize($image_file['tmp_name']);


            if($info === FALSE) {
                header('Location: /index.php');
                die();
            }

            $image_type = $info[2];

            if($image_type !== IMAGETYPE_GIF && $image_type !== IMAGETYPE_JPEG && $image_type !== IMAGETYPE_PNG) {
                header('Location: /index.php');
                die();
            }

            $author_id = $_SESSION['id'];
            $title = $req['title'];
            $descr = isset($req['descr']) ? $req['descr'] : NULL;
            $mime = image_type_to_mime_type($image_type);
            $contents = file_get_contents($image_file['tmp_name']);
            $thumb = thumb_create($image_file['tmp_name']);

            if($contents === FALSE) {
                header('Location: /index.php');
                die();
            }

            $res = Image::insert($author_id, $title, $descr, $mime, $contents, $thumb);

            header('Location: /views/gallery.php?status="File succesfully uploaded"');
            die();
        }

        static function allowed_ids($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /index.php');
                die();
            }

            $user_id = $_SESSION['id'];

            $ids = Image::get_allowed_ids($user_id);

            header('Content-Type: application/json');
            echo json_encode($ids);
            die();
        }

        static function fetch_raw($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /index.php');
                die();
            }

            if(!isset($req['id'])) {
                header('Location: /index.php');
                die();
            }

            $id = $req['id'];

            $image = Image::get_by_id($id);

            header('Content-Type: ' . $image->mime);
            echo $image->contents;
            die();
        }

        static function fetch_thumb_raw($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /index.php');
                die();
            }

            if(!isset($req['id'])) {
                header('Location: /index.php');
                die();
            }

            $id = $req['id'];

            $image = Image::get_by_id($id);

            header('Content-Type: ' . $image->mime);
            echo $image->thumb;
            die();
        }
    }
?>
