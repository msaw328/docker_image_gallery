<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/config.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/image.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/models/category.php');

    if(!sess_is_logged_in()) {
        header('Location: /views/login.php');
        die();
    }

    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: /views/gallery.php?status=Invalid request');
        die();
    }

    $img_id = $_GET['id'];

    // there should be a controller somewhere here :(
    $image = Image::get_metadata_by_id($img_id);

    if(is_null($image)) {
        header('Location: /views/gallery.php?status=No such image');
        die();
    }

    if(is_a($image, 'Exception')) {
        header('Location: /views/gallery.php?status=DB error');
        die();
    }

    $is_user_owner = $_SESSION['id'] === $image->author_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>
        Edit image info
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" />
    <link rel="stylesheet" href="/views/css/edit.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="three columns">
                <a href="/views/gallery.php" class="button button-primary">
                    Back to gallery
                </a>
            </div>
            <div class="nine columns">
                <?php
                    if(isset($_GET['status']))
                    echo '<h3>Status: ' . htmlspecialchars($_GET['status']) .'</h3>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="six columns">
                <img id="imagePreview" src="/index.php?controller=image&action=fetch_raw&id=<?php echo $img_id ?>" />
            </div>
            <div class="six columns">
                <form id="imageEditForm" method="POST" action="/index.php?controller=image&action=alter_meta&id=<?php echo $img_id ?>">
                    <label for="imgTitleInput">
                        Image title:
                    </label>
                    <input id="imgTitleInput" maxlength="<?php echo DB_MAX_IMAGE_TITLE_LEN ?>" type="text" name="title" value="<?php echo $image->title; ?>" <?php if(!$is_user_owner) echo 'disabled'; ?>/>
                    <label for="deleteCategorySelect">
                        Category:
                    </label>
                    <select id="deleteCategorySelect" name="cat_id" <?php if(!$is_user_owner) echo 'disabled'; ?>>
                        <?php
                            // generate options for category select
                            if(!$is_user_owner)
                                echo '<option value="none" selected>[private]</option>';
                            else {
                                $cats = Category::get_owned($_SESSION['id']);

                                foreach ($cats as $cat) {
                                    echo '<option value="' . $cat->id . '" ';
                                    if($image->cat_id === $cat->id)
                                        echo 'selected';

                                    echo '>' . $cat->name . '</option>';
                                }

                                echo '<option value="NULL" ';
                                if($image->cat_id == NULL)
                                    echo 'selected';
                                echo '>[no category]</option>';
                            }
                        ?>
                    </select>
                    <label for="imgDescrInput">
                        Description:
                    </label>
                    <textarea id="imgDescrInput" maxlength="<?php echo DB_MAX_IMAGE_DESCR_LEN ?>" name="descr" <?php if(!$is_user_owner) echo 'disabled'; ?>><?php echo $image->descr; ?></textarea>
                    <label for="imgCreationDate">
                        Creation date: <?php echo $image->created_at; ?>
                    </label>
                    <input type="submit" value="<?php if($is_user_owner) echo "Edit"; else echo "You can't edit this picture"; ?>" <?php if($is_user_owner) echo 'class="button-primary"'; else echo 'disabled' ?>/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
