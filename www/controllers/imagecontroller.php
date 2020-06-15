<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/image.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/config.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/thumb.inc.php');

    class ImageController {
        static function upload($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /index.php');
                die();
            }

            if(!isset($req['title']) || !isset($files['image_file'])) {
                header('Location: /views/gallery.php?status="Invalid request"');
                die();
            }

            if(mb_strlen($req['title']) > DB_MAX_IMAGE_TITLE_LEN) {
                header('Location: /views/gallery.php?status="Title too long"');
                die();
            }

            if(isset($req['descr']) && mb_strlen($req['descr']) > DB_MAX_IMAGE_DESCR_LEN) {
                header('Location: /views/gallery.php?status="Description too long"');
                die();
            }

            $image_file = $files['image_file'];

            if($image_file['error'] !== UPLOAD_ERR_OK) {
                header('Location: /views/gallery.php?status="Uplaod failed"');
                die();
            }

            if(!is_uploaded_file($image_file['tmp_name'])) {
                header('Location: /views/gallery.php?status="Invalid file access"');
                die();
            }

            $info = getimagesize($image_file['tmp_name']);


            if($info === FALSE) {
                header('Location: /views/gallery.php?status="Invalid file type"');
                die();
            }

            $image_type = $info[2];

            if($image_type !== IMAGETYPE_GIF && $image_type !== IMAGETYPE_JPEG && $image_type !== IMAGETYPE_PNG) {
                header('Location: /views/gallery.php?status="Invalid image type"');
                die();
            }

            $author_id = $_SESSION['id'];
            $title = $req['title'];
            $descr = isset($req['descr']) ? $req['descr'] : NULL;
            $mime = image_type_to_mime_type($image_type);
            $contents = file_get_contents($image_file['tmp_name']);
            $thumb = thumb_create($image_file['tmp_name']);

            if($contents === FALSE) {
                header('Location: /views/gallery.php?status="Could not load contents of the file"');
                die();
            }

            $res = Image::insert($author_id, $title, $descr, $mime, $contents, $thumb);

            header('Location: /views/gallery.php?status="File succesfully uploaded"');
            die();
        }

        static function allowed_ids($req, $files) {
            if(!sess_is_logged_in()) {
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
                die();
            }

            if(!isset($req['id'])) {
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
                die();
            }

            if(!isset($req['id'])) {
                die();
            }

            $id = $req['id'];

            $image = Image::get_by_id($id);

            header('Content-Type: ' . $image->mime);
            echo $image->thumb;
            die();
        }

        static function fetch_metadata_json($req, $files) {
            if(!sess_is_logged_in()) {
                die();
            }

            if(!isset($req['id'])) {
                die();
            }
            
            $image = Image::get_by_id($req['id']);

            header('Content-Type: application/json');

            $response = [
                'id' => $image->id,
                'author_id' => $image->author_id,
                'cat_id' => $image->cat_id,
                'title' => $image->title,
                'descr' => $image->descr,
                'created_at' => $image->created_at,
                'mime' => $image->mime
            ];

            echo json_encode($response);
            die();
        }

        
    }
?>
