<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/category.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/config.inc.php');

    class CategoryController {
        static function get_owned($req, $files) {
            if(!sess_is_logged_in()) {
                die();
            }

            $id = $_SESSION['id'];

            $categories = Category::get_owned($id);

            header('Content-Type: application/json');
            echo json_encode($categories);
            die();
        }

        static function create($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /views/login.php');
                die();
            }

            if(!isset($req['name'])) {
                header('Location: /viws/gallery.php?status="Invalid request"');
                die();
            }

            $owner_id = $_SESSION['id'];

            if(mb_strlen($req['name']) > DB_MAX_CAT_NAME_LEN) {
                header('Location: /viws/gallery.php?status="Category name too long"');
                die();
            }

            Category::insert($owner_id, $req['name']);

            header('Location: /views/gallery.php?status="Added new category"');
            die();
        }

        static function delete($req, $files) {
            if(!sess_is_logged_in()) {
                header('Location: /index.php');
                die();
            }

            if(!isset($req['id'])) {
                header('Location: /viws/gallery.php?status="Invalid request"');
                die();
            }

            $user_id = $_SESSION['id'];
            $cat_id = $req['id'];

            $cat = Category::get($cat_id);

            if(is_null($cat)) {
                header('Location: /views/gallery.php?status="No such category"');
                die();
            }

            if($cat->owner_id != $user_id) {
                header('Location: /views/gallery.php?status="Only owner can delete category"');
                die();
            }

            Category::delete($cat_id);

            header('Location: /views/gallery.php?status="Category deleted"');
            die();            
        }
    }
?>
