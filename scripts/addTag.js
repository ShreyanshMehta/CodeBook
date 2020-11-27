async function postData(url, data) {
    return fetch(url, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        redirect: 'follow',
        referrer: 'no-referrer',
        body: data,
    }).then(response => response.json());
}

var base_url = document.getElementById('base_url').innerHTML;
var btn = document.getElementById('modalboxbtn');
var input = document.getElementById('modalInput');
var msg = document.getElementById('modalmsg');
var title = document.getElementById('modaltitle');
var close = document.getElementById('modalclose');
var del = document.getElementById('del');

function addTag(e) {
    var code = e.parentElement.parentElement.children[0].children[0].innerText;
    var author = e.parentElement.parentElement.children[1].innerText;
    var ss = e.parentElement.parentElement.children[2].innerText;
    var attempt = e.parentElement.parentElement.children[3].innerText;
    title.innerHTML = code + " - Add Tag";
    btn.onclick = function() {
        if (input.value == "") {
            msg.style.color = 'red';
            msg.innerHTML = "Please insert the tag!";
        } else {
            insertTag(input.value, code, author, ss, attempt);
            msg.style.color = 'green';
            msg.innerHTML = "Tag Added Successfully!";
        }
        input.value = "";
        msg.style.visibility = 'visible';
    }
}

function delQues(e) {
    var code = e.parentElement.parentElement.children[0].innerText;
    var tag = document.querySelector('h2').innerHTML;
    tag = tag.split('#')[1];
    console.log(tag);
    const formData = new FormData();
    formData.append('tag', tag);
    formData.append('code', code);
    postData(base_url + '/privateTag/delQues', formData)
        .then(data => {
            if (data['status'] == 1) {
                location.reload();
            }
        });
}

function delTag(e) {
    var tag = e.parentElement.parentElement.children[1].children[0].innerText;
    const formData = new FormData();
    formData.append('tag', tag);
    postData(base_url + '/privateTag/delTag', formData)
        .then(data => {
            if (data['status'] == 1) {
                location.reload();
            }
        });
}

close.onclick = function() {
    msg.style.visibility = 'hidden';
}

function insertTag(tag, code, author, solved, attempted) {
    const formData = new FormData();
    formData.append('tag', tag);
    formData.append('code', code);
    formData.append('author', author);
    formData.append('attempted', attempted);
    formData.append('solved', solved);
    postData(base_url + '/addTag', formData);
}

console.log(base_url);