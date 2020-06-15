<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/config.inc.php');

    if(!sess_is_logged_in()) {
        header('Location: /views/login.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>
        Gallery
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" />
    <link rel="stylesheet" href="/views/css/gallery.css" />
    <script src="/views/js/quickajax.js">
    </script>
    <script src="/views/js/gallery.js">
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="three columns">
                <form id="logoutForm" method="POST" action="/index.php?controller=auth&action=logout">
                    <input type="submit" value="Logout" class="button-primary" />
                </form>
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
                <form id="imageForm" method="POST" enctype="multipart/form-data" action="/index.php?controller=image&action=upload">
                    <label for="imgTitleInput">
                        Image title:
                    </label>
                    <input id="imgTitleInput" maxlength="<?php echo DB_MAX_IMAGE_TITLE_LEN ?>" type="text" name="title" />
                    <label for="imgDescrInput">
                        Description:
                    </label>
                    <textarea id="imgDescrInput" maxlength="<?php echo DB_MAX_IMAGE_DESCR_LEN ?>" name="descr"></textarea>
                    <input id="imgFileInput" type="file" name="image_file" accept="image/jpeg,image/gif,image/png" />
                    <div id="fileDropArea" class="fileDropAreaClear">
                        ..or drop a file here!
                    </div>
                    <input type="submit" value="Upload" class="button-primary" />
                </form>
            </div>
            <div class="three columns">
                <form id="categoryAddForm" method="POST" action="/index.php?controller=category&action=create">
                    <label for="addCategoryName">
                        Category name:
                    </label>
                    <input id="addCategoryName" type="text" name="name" />
                    <input type="submit" value="Add new category" class="button-primary" />
                </form>
            </div>
            <div class="three columns">
                <form id="categoryDelForm" method="POST" action="/index.php?controller=category&action=delete">
                    <label for="deleteCategorySelect">
                        Category name:
                    </label>
                    <select id="deleteCategorySelect" name="id">
                        <option value="none">no selection</option>
                    </select>
                    <input id="deleteCategorySubmit" type="submit" value="Delete category" disabled />
                </form>
            </div>
        </div>
        <div class="row">
            <div class="twelve columns">
                <div id="pictureDiv">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
