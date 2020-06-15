(() => {
    // create images on site from database
    function fetchAndRefreshPictures(container) {
        quickajax(
            'GET',
            '/index.php?controller=image&action=allowed_ids',
            (data) => {
                var allowed_ids = JSON.parse(data)

                for (id of allowed_ids) {
                    var img = new Image()

                    img.dataset.id = id
                    img.src = '/index.php?controller=image&action=fetch_thumb_raw&id=' + id

                    container.appendChild(img)
                }
            })
    }

    // add options to "Delete category" select based on owned options
    function fetchAndRefreshCategories(select) {
        quickajax(
            'GET',
            '/index.php?controller=category&action=get_owned',
            (data) => {
                var categories = JSON.parse(data)

                for (cat of categories) {
                    var opt = new Option()

                    opt.value = cat.id
                    opt.innerHTML = cat.name

                    select.appendChild(opt)
                }
            })
    }

    window.onload = () => {
        var pictureDiv = document.getElementById('pictureDiv')
        var deleteCategorySelect = document.getElementById('deleteCategorySelect')
        var deleteCategorySubmit = document.getElementById('deleteCategorySubmit')
        var fileDropArea = document.getElementById('fileDropArea')
        var fileInput = document.getElementById('imgFileInput')

        // if the 'none' option is selected, disable sbumit button for the form
        deleteCategorySelect.onchange = () => {
            if(deleteCategorySelect.value === 'none') {
                deleteCategorySubmit.disabled = true
                deleteCategorySubmit.classList.remove('button-primary')
            } else {
                deleteCategorySubmit.disabled = false
                deleteCategorySubmit.classList.add('button-primary')
            }
        }

        fetchAndRefreshPictures(pictureDiv)
        fetchAndRefreshCategories(deleteCategorySelect)

        fileDropArea.ondrop = (e) => {
            e.preventDefault()

            var files = e.dataTransfer.files

            if(files.length != 1) {
                alert('Please drop only one file at a time!')
                fileDropArea.classList.remove('fileDropAreaDragged')
                return
            }

            fileInput.files = files
        }

        fileDropArea.ondragover = (e) => {
            e.preventDefault()
            fileDropArea.classList.add('fileDropAreaDragged')
        }

        fileDropArea.ondragend = fileDropArea.ondragleave = (e) => {
            e.preventDefault()
            fileDropArea.classList.remove('fileDropAreaDragged')
        }
    }
})();
