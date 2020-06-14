<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/session.inc.php');

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
    <script>

        window.onload = () => {
            var pictureDiv = document.getElementById('pictureDiv');
            var deleteCategorySelect = document.getElementById('deleteCategorySelect');

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if(xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        var allowed_ids = JSON.parse(xhr.responseText)
                        for(id of allowed_ids) {
                            var img = new Image()
                            img.dataset.id = id
                            img.src = '/index.php?controller=image&action=fetch_thumb_raw&id=' + id
                            pictureDiv.appendChild(img)
                        }
                    } else {
                        console.log('there was a problem with the request');
                    }
                }
            }

            xhr.open('GET', '/index.php?controller=image&action=allowed_ids');
            xhr.send();

            var xhr2 = new XMLHttpRequest();
            xhr2.onreadystatechange = () => {
                if(xhr2.readyState === XMLHttpRequest.DONE) {
                    if(xhr2.status === 200) {
                        var categories = JSON.parse(xhr2.responseText)
                        
                        for(cat of categories) {
                            var opt = new Option()
                            opt.value = cat.id
                            opt.innerHTML = cat.name
                            deleteCategorySelect.appendChild(opt)
                        }
                    } else {
                        console.log('there was a problem with the request');
                    }
                }
            }

            xhr2.open('GET', '/index.php?controller=category&action=get_owned');
            xhr2.send();
        }

    </script>
</head>
<body>
    <?php
        if(isset($_GET['status']))
        echo '<p>Status: ' . htmlspecialchars($_GET['status']) .'</p>';
    ?>
    <form method="POST" action="/index.php?controller=auth&action=logout">
        <input type="submit" value="Logout" />
    </form>
    <form method="POST" enctype="multipart/form-data" action="/index.php?controller=image&action=upload">
        <input type="text" name="title" />
        <textarea name="descr"></textarea>
        <input type="file" name="image_file" />
        <input type="submit" value="Upload" />
    </form>
    <form method="POST" action="/index.php?controller=category&action=create">
        <input type="text" name="name" placeholder="Name of new category" />
        <input type="submit" value="Add new category" />
    </form>
    <form method="POST" action="/index.php?controller=category&action=delete">
        <select id="deleteCategorySelect" name="id">
        </select>
        <input type="submit" value="Delete category" />
    </form>
    <br />
    <br />
    <div id="pictureDiv">
    </div>
</body>
</html>
