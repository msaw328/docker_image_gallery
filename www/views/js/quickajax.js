
function quickajax(method, url, callback) {
    var xhr = new XMLHttpRequest()

    xhr.onreadystatechange = () => {
        if(xhr.readyState !== XMLHttpRequest.DONE) {
            return
        }

        if(xhr.status !== 200) {
            console.log('AJAX - ' + method + ' | ' + url + ' | FAILED')
            return
        }

        callback(xhr.responseText)
    }

    xhr.open(method, url)
    xhr.send()
}
